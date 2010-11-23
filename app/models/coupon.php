<?php
class Coupon extends AppModel {

	var $name = 'Coupon';
	var $couponErrors = array();
	var $actsAs = array('Containable');
	//The Associations below have been created with all possible keys, those that are not needed can be remove
	 
	var $hasMany = array(
		'CouponsUsed' => array(
			'className' => 'CouponsUsed',
			'foreignKey' => 'disc_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '', 
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	var $hasAndBelongsToMany = array(
		'Product' => array(
			'className' => 'Product',
			'joinTable' => 'coupons_required_products',
			'foreignKey' => 'coupon_id',
			'associationForeignKey' => 'product_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
	
	var $belongsTo = array(
		'Groupon' => array(
			'className' => 'Groupon',
			'foreignKey' => 'code',
		)
	);
	
	
	function getCoupons($cartItems = array(), $totalPriceNoTaxNoShipping = 0){
		App::import('Vendor', 'connections');
		$siteConfig = new Connections();
		
		//select manually entered coupons
		$preValidatedCoupons = array();
		$coupons = array();
		if(isset($_SESSION['cart']['code'])){
			foreach ($_SESSION['cart']['code'] as $code=>$coupon){
				$foundCoupon = $this->find('first',array('conditions'=>array('OR'=>array('code LIKE'=>$code),
																		'site_id' =>$siteConfig->getCartDBField('site_id')
																		),
													     'contain'=>array('Product','CouponsUsed','Groupon'),
														 'order' => 'auto ASC'));
				if(!empty($foundCoupon)){
					//add shippingDiscounts into an array
					$possibleDiscounts = $this->getShippingDiscountTypes($foundCoupon);
					if(!empty($possibleDiscounts)){
						$foundCoupon['Coupon']['shippingDiscounts'] = $possibleDiscounts;
					}
					$foundCoupon = $this->validateCoupon($foundCoupon, $cartItems, $totalPriceNoTaxNoShipping);
					if(is_array($foundCoupon)){
						$coupons[] = $foundCoupon;
					}
				}	
			}
		}

		//select automatic coupons then validate:
		$autoCoupons = $this->find('all',array('conditions'=>array('auto'=>1,
																	 'site_id' =>$siteConfig->site_id
																	),
												 'contain'=>array('Product','CouponsUsed'),
												 'order' => 'auto ASC'));
		foreach ($autoCoupons as $autoCoupon){
			$possibleDiscounts = $this->getShippingDiscountTypes($autoCoupon);
			if(!empty($possibleDiscounts)){
				$autoCoupon['Coupon']['shippingDiscounts'] = $possibleDiscounts;
			}
			$autoCoupon = $this->validateCoupon($autoCoupon, $cartItems, $totalPriceNoTaxNoShipping);
			if(is_array($autoCoupon)){
				$coupons[] = $autoCoupon;
			}
		}												
		return $coupons;
	}
	
	function applyByDiscountType($amountToDiscount, $discountAmount, $discountType){
		switch($discountType){
			case 'percent':
				$discount = (($amountToDiscount * $discountAmount) / 100);
				$amountToDiscount = $amountToDiscount - $discount;
			break;
			case 'flat':
				$amountToDiscount -= $discountAmount;
				if($amountToDiscount < 0){
					$amountToDiscount = 0;
				}
			break;
		}
		$amountToDiscount = number_format($amountToDiscount, 2);
		return $amountToDiscount;
	}
	
	function getDiscountAmount($amountToDiscount, $discountAmount, $discountType){
		switch($discountType){
			case 'percent':
				$discount = (($amountToDiscount * $discountAmount) / 100);
			break;
			case 'flat':
				$proposedAmount = $amountToDiscount - $discountAmount;
				if($proposedAmount < 0){
					$discount = $proposedAmount + $discountAmount;
				}
				
				$discount = $discountAmount;
			break;
		}
		$discount = number_format($discount, 2);
		return $discount;
	}
	
	function getCouponErrorMessages(){
		if(!empty($this->couponErrors)){
			foreach($this->couponErrors as $coupon_id=>$err){
				//coupon errors are only showed once, and checks if error was already displayed to user:
				if(isset($_SESSION['cart']['Coupon'][$coupon_id]['message_already_displayed']) &&
				   $_SESSION['cart']['Coupon'][$coupon_id]['message_already_displayed'] == 1){
				   		unset($this->couponErrors[$coupon_id]);
				}else{
					if(!isset($_SESSION['cart']['Coupon'])){
						$_SESSION['Coupon'] = array();
					}
					if(!isset($_SESSION['cart']['Coupon'][$coupon_id])){
						$_SESSION['Coupon'][$coupon_id] = array();
					}
					$_SESSION['cart']['Coupon'][$coupon_id]['message_already_displayed'] = 1;
				}
			}
			$msg = implode(", ",$this->couponErrors);

			$this->couponErrors = array();
			return $msg;
		}
		return false;
	}
	
	/**
	 * 
	 * All coupons should be validated before this method is run. 
	 * 
	 * @param $coupons
	 * @param $shippingType
	 * @param $cartItems
	 * @param $allTotals
	 */
	function applyCoupons($coupons, $shippingType = null, $cartItems, $allTotals){
		$totalDiscount = 0;
		$shippingAlreadyDiscounted = false;
		foreach($coupons as $coupon){
			$amountToDiscount = 0;
			$couponCase = $coupon['Coupon']['discountto'];		
		
			//check for discount type overrides like quantity_range_max:
			if($coupon['Coupon']['quantity_range_max'] > 0 && $coupon['Coupon']['restrict_to_group']==1){
				$couponCase = 'quantity_range';
			

			//check for maxitems and apply discount only to that number of items unless set to shipping or grand total
			}else if($coupon['Coupon']['maxitems'] > 0 && $coupon['Coupon']['restrict_to_group']==1){
				$couponCase = 'maximum_number_of_items';
				
			//check for product specific item(s) without maxitems set, so you will apply a discount only to those items:																		
			}else if(!empty($coupon['Product'])){
				if($coupon['Coupon']['restrict_to_group']==1){
					$couponCase = 'specific_items';
				}
			}
			switch ($couponCase){
				//apply discount only to the item or group of items selected
				case 'specific_items':
					$discountItemsSubTotal = 0;
					$productsFound = 0;
					$countProducts = count($coupon['Product']);
					foreach ($cartItems as $item){
						foreach($coupon['Product'] as $prod){
							if($item['id'] == $prod['id']){
								$productsFound++;
								$discountItemsSubTotal += $item['price'] * $item['qty'];
							}
						}
					}
					//all required products are in cart:
					if($productsFound == $countProducts){
						$amountToDiscount = $discountItemsSubTotal;
					}
				break;
				case 'maximum_number_of_items':
					$itemCount = 0;
					foreach ($cartItems as $item){
						if($itemCount >= $coupon['Coupon']['maxitems']){
							break;
						}else{
							//check item quantities and add quantites to the itemCount:
							if($itemCount + $item['qty'] > $coupon['Coupon']['maxitems']){
								//if maxed out, find the difference and apply discount:
								$difference = $itemCount + $item['qty'] - $coupon['Coupon']['maxitems'];
								$amountToDiscount += $item['price'] * ($item['qty'] - $difference);
								$itemCount =  $coupon['Coupon']['maxitems'];
							}else{//apply discount:
								$amountToDiscount += $item['price'] * $item['qty'];
								$itemCount += $item['qty'];
							}
						}
					}
				break;
				case 'quantity_range':
					//we must apply the quantity range discount type only to the item involved, not all cart items,
					//so we have to separate the items to discount from all other items:
					foreach ($cartItems as $item){
						foreach($coupon['Product'] as $prod){
							if($item['id'] == $prod['id']){
								$amountToDiscount += $item['price'] * $item['qty'];
							}
						}
					}
				break;
				case 'subtotal':
					///take discount out of subtotal:
					$amountToDiscount += $allTotals['noTaxNoShipping'];
				break;
				case 'shipping':
					if(isset($coupon['Coupon']['shippingDiscounts'][$shippingType])){
						if(!$shippingAlreadyDiscounted){
							$amountToDiscount += $allTotals['shippingPrice'];
							$shippingAlreadyDiscounted = true;
						}
					}
				break;
				case 'grandtotal':
					//this code can only be fully applied when shipping is calculated
					if(isset($coupon['Coupon']['shippingDiscounts'][$shippingType])){
						//apply coupon and include shipping price:
						if(!$shippingAlreadyDiscounted){
							$amountToDiscount += $this->getGrandTotal(array(), $allTotals);
							$shippingAlreadyDiscounted = true;
						}else{
							$amountToDiscount += $this->getGrandTotal(array('shippingPrice'), $allTotals);	
						}
					}else{
						//apply coupon but make them pay for expensive shipping:
						$amountToDiscount += $this->getGrandTotal(array('shippingPrice'), $allTotals);
					}
				break;
			}
			//apply discount
			$totalDiscount += $this->getDiscountAmount($amountToDiscount, 
														$coupon['Coupon']['discountamount'],
														$coupon['Coupon']['discounttype']);
		}
		return $totalDiscount;
	}
	
	
	/**
	 * 
	 * @param unknown_type $minus array of keys to exclude from totals
	 * @param $allTotals array of totals from cart, see Cart->getTotals()  method
	 * 
	 * this function will calculate the grand total, and if you pass $allTotals keys 
	 * (eg shippingPrice, totalTax) into the array, it will excludde from grand total
	 */
	private function getGrandTotal($minus = array(), $allTotals = array()){
		foreach($minus as $m){
			unset($allTotals[$m]);
		}
		$total = 0;
		foreach ($allTotals as $t){
			$total += $t;
		}
		return $total;
	}
		
	//return shippingDiscounts for insertion into coupon array
	private function getShippingDiscountTypes($coupon){
		//get shipping types from shipping component
		App::import('Model','ShippingCode');
		$ShippingCode = new ShippingCode();
		$shippingTypes = $ShippingCode->find('list', array('fields' => array('ShippingCode.id', 'ShippingCode.coupon_field_name'),
														   'conditions'=>array('in_carts'=>1)));
		$shippingDiscounts = array();
		if($coupon['Coupon']['discountto'] == 'shipping'){
			foreach($shippingTypes as $key=>$shippingType){
				if($coupon['Coupon'][$shippingType] == 1){
					$shippingDiscounts[$key] = $shippingType;
				}
			}
		}
		if($coupon['Coupon']['discountto'] == 'grandtotal'){
			foreach($shippingTypes as $key=>$shippingType){
				if($coupon['Coupon'][$shippingType] == 1){
					$shippingDiscounts[$key] = $shippingType;
				}
			}
		}
		return $shippingDiscounts;
	}
	
	
	//set validation functions here:
	private function validateCoupon($coupon = array(), $cartItems = array(), $totalPriceNoTaxNoShipping = 0){
		$disableMessage = $coupon['Coupon']['auto'];
		if(!$this->checkDateRange($coupon)){
			if(!$disableMessage){
				$this->couponErrors[$coupon['Coupon']['id']] =  'Coupon No Longer Valid: Out of Date Range.';
			}
			return false;
		}
		if(!$this->checkNumberOfUses($coupon)){
			if(!$disableMessage){
				$this->couponErrors[$coupon['Coupon']['id']] =   'Coupon No Longer Valid: Exeeded Max Number of Uses.';
			}
			return false;
		}
		/*
		if(!$this->checkRequiredItem($coupon, $cartItems)){
			return false;
		}*/
		if(!$this->checkMinPrice($coupon, $totalPriceNoTaxNoShipping)){
			if(!$disableMessage){
				$this->couponErrors[$coupon['Coupon']['id']] =   'Total Price Does Not Meet Minimum for Coupon To Apply: '.urldecode($coupon['Coupon']['description']);
			}
			return false;
		}
		if(!$this->checkMinItems($coupon, $this->countCartItems($cartItems))){
			if(!$disableMessage){
				$this->couponErrors[$coupon['Coupon']['id']] =   'You Must Add More Items to Your Cart for Coupon to Apply: '.urldecode($coupon['Coupon']['description']);
			}
			return false;
		}
		if(!$this->checkItemGroup($coupon, $cartItems)){
			if(!$disableMessage){
				$this->couponErrors[$coupon['Coupon']['id']] =   'Additional Item(s) needed for Coupon to Apply: '.urldecode($coupon['Coupon']['description']);
			}
			return false;
		}
		if(!$this->checkItemQtys($coupon, $cartItems)){
			if(!$disableMessage){
				$this->couponErrors[$coupon['Coupon']['id']] =   'Quantity Out of Range for Coupon to Apply: '.urldecode($coupon['Coupon']['description']);
			}
			return false;
		}
		
		if(!$disableMessage){
			if(isset($_SESSION['Coupon'][$coupon['Coupon']['id']]['message_already_displayed'])){
				unset($_SESSION['Coupon'][$coupon['Coupon']['id']]['message_already_displayed']);
			}
			$this->couponErrors[$coupon['Coupon']['id']] =  'Coupon Applied: '.urldecode($coupon['Coupon']['description']);
		}
		return $coupon;
		
	}
	
	private function countCartItems($cartItems){
		$qtys = Set::extract($cartItems,"{n}.qty");
		return array_sum($qtys);
	}
	
	private function checkDateRange($coupon = array()){
		//get start date
		///$required_time = false;
		if ( $coupon['Coupon']['start_date'] == null || $coupon['Coupon']['start_date'] == '0000-00-00') 
		{
			$startdate = mktime(0, 0, 0, 0, 0, 0);
			//$required_time = true;
		}else{
			$startdate = strtotime($coupon['Coupon']['start_date']);
		}
		
		//get end_date
		if ($coupon['Coupon']['end_date'] == null || $coupon['Coupon']['end_date'] == '0000-00-00') 
		{
			$enddate = mktime(24, 0, 0, "12", "31", "2037");
		}else{
			$enddate = strtotime($coupon['Coupon']['end_date']) + (60 * 60 * 24);
		}
		$now = time();
		
		
		//check date range:
		if(!(($now >= $startdate) && ($now <= $enddate)))//|| $required_time
		{
			return false;
		}
		return $coupon;
	}
	
	
	private function checkNumberOfUses($coupon = array()){
		$uses = count($coupon['CouponsUsed']);
		unset($coupon['CouponsUsed']);
		
		//check number of uses
		if(!($uses < $coupon['Coupon']['uses'] || $coupon['Coupon']['uses'] == -1))
		{
			return false;	
		}
		return $coupon;
	}
	
	/*
	private function checkRequiredItem($coupon = array(), $cartItems = array())
	{
		$required_item = false;
		if ($coupon['Coupon']['requireditem'] == -1) {
			$required_item=true;
		}else{
			foreach($cartItems as $item){
				if($item['id'] == $coupon['Coupon']['requireditem']){
					$required_item = true;
					break;
				}
			}
		}
		if($required_item == false){
			return false;
		}
		return $coupon;
	}*/
	
	private function checkMinPrice($coupon = array(), $total = 0)
	{
		if($coupon['Coupon']['minprice'] > 0){
			if($total < $coupon['Coupon']['minprice']){
				return false;
			}
		}
		return $coupon;
	}
	
	private function checkMinItems($coupon = array(),$itemCount = 0)
	{
		if($itemCount < $coupon['Coupon']['minitems']){
			return false;
		}
		return $coupon;
	}
	
	private function checkItemGroup($coupon = array(), $cartItems = array()){
		if (isset($coupon['Product']) && !empty($coupon['Product'])){
			$totalItemsNeeded = count($coupon['Product']);
			$totalItemsFound = 0;
			foreach($cartItems as $item){
				foreach($coupon['Product'] as $requiredItem){
					if($item['Product']['id'] == $requiredItem['id']){
						$totalItemsFound++;
					}
				}
			}
			if($totalItemsFound != $totalItemsNeeded){
				return false;
			}
		}
		return $coupon;
	}
	
	private function checkItemQtys($coupon = array(), $cartItems = array()){
		if($coupon['Coupon']['quantity_range_min'] > 0 && $coupon['Coupon']['quantity_range_max'] > 0){
			$itemQty = 0;
				
			foreach ($coupon['Product'] as $cProduct){
				foreach ($cartItems as $item){
					if($cProduct['id'] == $item['id']){
						$itemQty += $item['qty'];
					}
				}
			}
			if($coupon['Coupon']['quantity_range_min'] <= $itemQty && $itemQty <= $coupon['Coupon']['quantity_range_max']){
				return $coupon;
			}else{
				return false;
			}
		}
		return $coupon;
	}
}
?>