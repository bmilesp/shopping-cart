<?php

/*
 * the cart relies heavily on the session to gather most of it's information.
 */


class CartComponent extends Object {
    
		var $components = array('Tax','Shipping');
		var $Coupon = null;
		var $PogoCart = null;
		var $ColorsProduct = null;
		var $Product = null;
		var $siteConfig = null;
		var $items = array();
		var $sum_tax = 0;
		var $totals = array('shippingPrice'=>0,'giftWrapTotal'=>0,'noTaxNoShipping'=>0,
		                    'shippingTax'=>0,'itemsTax'=>0,'totalTax'=>0, 'cartItemsOnly'=>0, 
		                    'qty'=>0, 'total'=>0, 'discount'=>0);
		//var $shippingType = 1; //default shipping usps in shipping_codes table
		var $coupons = array();
		var $hasGiftwrapping = 0;
		var $hasPogoItems = false;
		var $giftWrapPricePerItem = null;
		var $itemImageUrl = "https://carts.undergroundshirts.com/prod_img/";
		var $controller;

		
		function initialize(){
			App::import('Model', 'PogoCart');
            $this->PogoCart = new PogoCart();
            App::import('Model', 'ColorsProduct');
            $this->ColorsProduct = new ColorsProduct();
            App::import('Model', 'Product');
            $this->Product = new Product();
			App::import('Model', 'Coupon');
            $this->Coupon = new Coupon();
            App::import('Vendor', 'Connections');
            $this->siteConfig = new Connections();
		}
		
        function startup(&$controller) {//startup method is called after session is initiated
        	$this->controller =& $controller;
      	  	if (isset($_SESSION['cart'])){
      	  		if(!isset($_SESSION['cart']['items'])){
	        		if(isset($_SESSION['cart']['id0'])){
						$i=0;
						
						//create a normalized array for cart items:
	        			while($i < $_SESSION['cart']['cart_size'])
	        			{
		        			foreach ($_SESSION['cart'] as $key=>$item_attr){
		        				if(strpos($key,"$i") > -1){
		        					$splitter = split($i,$key);
		        					$this->items[$i][$splitter[0]] = $item_attr;
		        				}
		        			}
	        			$i++;
	        			}
	        		}
      	  		}else{
      	  			$this->items = $_SESSION['cart']['items'];
      	  		}
        		//get gift wrap pricing (if set):
        		if(isset($_SESSION['cart']['gift']) && $_SESSION['cart']['gift'] == 1 ){
        			$this->hasGiftwrapping = 1;
	        		$this->giftWrapPricePerItem = $this->getGiftWrapPrice();
	        	}
	        	
	        	
	        	//get various cart totals and item information:
	        	$initialCartTotal = 0;
	        	$this->totals['qty'] = 0;
	        	foreach ($this->items as $key=>$item){
	        		//add colors_products info
	        		$this->ColorsProduct->Contain(array('Product','Color'));
	        		$colorsProduct = $this->ColorsProduct->find('first',array('conditions'=>array('prod_id'=>$item['id'],'color_id'=>$item['color_id'])));
	        		$this->items[$key]['ColorsProduct'] = $colorsProduct['ColorsProduct'];
	        		$this->items[$key]['Color'] = $colorsProduct['Color'];
	        		//add backordered flag to items array
        			$this->items[$key]['isBackordered'] = ($this->ColorsProduct->isBackordered($this->items[$key]['ColorsProduct']['id'],$item['size']))?1:0;
	        		//add item status with all flag to items array
        			$this->items[$key]['thisItemStatus'] = $this->ColorsProduct->thisItemStatus($this->items[$key]['ColorsProduct']['id'],$item['size']);
	        		if(!($this->items[$key]['thisItemStatus']['U'] || 
							($this->items[$key]['thisItemStatus']['B'] && !$this->items[$key]['thisItemStatus']['O']) || 
							($this->items[$key]['thisItemStatus']['AB'] && !$this->items[$key]['thisItemStatus']['O'])
						)){ 
	        			$this->totals['cartItemsOnly'] += $item['price'] * $item['qty'];
	        			$this->totals['qty'] += $item['qty']; 
					}
	        		
	        		//get product info
	        		$this->Product->recursive = -1;
	        		$product = $this->Product->findById($item['id']);
	        		$this->items[$key]['Product'] = $product['Product'];
	        		
	        		//check if pogo items exist and get relevant info:
	        		if(isset($this->items[$key]['Product']['pogo_id']) &&
	        				 $this->items[$key]['Product']['pogo_id'] > 0){
	        			$this->PogoCart->recursive = -1;
	        			$pogoCart = $this->PogoCart->findByCartId($this->items[$key]['Product']['pogo_id']);
	        			$this->items[$key]['PogoCart'] = $pogoCart['PogoCart'];
	        		}
	        		
	        		//add giftwrapping if set
	        		if(isset($this->giftWrapPricePerItem))
	        		{
	        			$this->totals['giftWrapTotal'] += $this->giftWrapPricePerItem * $item['qty'];
	        		}
	        		     			
	        	}
	        	$this->totals['weight'] =  $this->Shipping->getTotalWeight($this->items);
	        	$this->totals['noTaxNoShipping'] = $this->totals['cartItemsOnly'] + $this->totals['giftWrapTotal'];
	        	$this->totals['total'] = $this->totals['noTaxNoShipping'];
        	}
        }
      
       
		
		function getTotals($shippingType, $shippingAddressId){
			$shippingAddress = $this->Shipping->getShippingAddress($shippingAddressId);
			
			$this->totals['shippingPrice'] = $this->Shipping->getShippingPrice($shippingType, $shippingAddressId, $this->items);
        	$this->totals['shipDates'] = $this->Shipping->getshipDates($shippingType, $shippingAddressId, $this->items);
			$this->coupons = $this->Coupon->getCoupons($this->items, $this->totals['noTaxNoShipping']);
			
			//$this->totals['itemsTax'] = $this->applyTaxToItems($shippingAddressId, $this->totals['noTaxNoShipping']);
			//$this->totals['shippingTax'] = $this->applyTaxToAmt($shippingAddress['ShippingAddress']['zip'], $this->totals['shippingPrice']);
			$this->applyCouponDiscounts($this->coupons, $shippingType, $this->items);
			$taxRate = ($this->Tax->getTaxRateByZip($shippingAddress['ShippingAddress']['zip'])/100);
			$this->totals['totalTax'] = $this->Tax->applyTaxByZip($this->totals['total'], $shippingAddress['ShippingAddress']['zip']);
			//debug($taxRate);
			//debug($this->totals['totalTax']);
			//debug($this->totals['total']);
        	$this->totals['total'] = number_format($this->totals['total'] + $this->totals['totalTax'],2);
			return $this->totals;
		}
		
		
		private function applyTaxToItems($shippingAddressId = null, $total = 0){
			$shippingAddress = $this->Shipping->getShippingAddress($shippingAddressId);
			$totalTaxable = $this->getTotalItemsCostTaxable($shippingAddress['ShippingAddress']['state']);
			//get total taxable % and total non-taxable %
			$totalTaxablePercent = $totalTaxable / $this->totals['cartItemsOnly'];
			$totalNonTaxablePercent = 1 - $totalTaxablePercent;
			
			//apply tax percentiles to total price
			$totalTaxableCost = $totalTaxablePercent * $total;
			
			//return tax rate
			return $this->applyTaxToAmt($shippingAddress['ShippingAddress']['zip'], $totalTaxableCost);
		}
		
		private function getTotalItemsCostTaxable($state = 'MI'){
			//get taxable items
			$totalCartItemsTaxable = 0;
			foreach($this->items as $item){
				if($this->Tax->isApparelTaxable($item['is_apparel'], $state))
        		{
        			$totalCartItemsTaxable += $item['price'] * $item['qty'];
        		}
			}
			$totalTaxable = $this->totals['noTaxNoShipping'];
			$totalTaxable *= ($totalCartItemsTaxable / $this->totals['cartItemsOnly']);
			return $totalTaxable;
		}
		
		private function applyTaxToAmt($zip = 48103, $amt = 0){
			//get tax rate
			$rate = $this->Tax->getTaxRateByZip($zip);
			return $amt * ($rate/100);
		}
		
		function addProduct($product = array()){
			$this->ColorsProduct->Contain(array('Product'=>array('ShippingGroup'),'Color'));
			$colorsProduct = $this->ColorsProduct->find('first',array('conditions'=>array(
																'prod_id'=>$product['product_id'],
																'color_id'=>$product['color_id'])));
			$key = $this->checkIfItemExists($colorsProduct['ColorsProduct'], $product['size'], $product['color_id']);
			if($key !== false){
				$this->controller->Session->setFlash(__(urldecode($colorsProduct['Product']['name'])." - ".urldecode($colorsProduct['Color']['color'])." - Size: {$product['size']} was already in the cart, so the quantity was updated.", true));
				$_SESSION['cart']['items'][$key]['qty'] += $product['qty'];
				 return true;
			}
	 	    $cartItem = array();
		    $cartItem['id'] = $product['product_id'];
		    $cartItem['color_id'] = $product['color_id'];
		    $cartItem['qty'] = $product['qty'];
		    $cartItem['price'] = $colorsProduct['Product']['price'];
		    $cartItem['name'] = $colorsProduct['Product']['name'];
		    $cartItem['size'] = $product['size'];
		    $cartItem['weight'] = $colorsProduct['Product']['ShippingGroup']['weight'];
		    $cartItem['usps_price'] = $colorsProduct['Product']['ShippingGroup']['usps_price'];
		    $cartItem['is_apparel'] = $colorsProduct['Product']['is_apparel'];
		    $_SESSION['cart']['items'][] = $cartItem;
			return true;   
		}
		
		function updateItem($ordersProduct = array('prod_id'=>null, 'color_id'=>null, 'qty'=>null)){
			foreach($_SESSION['cart']['items'] as $key=> $item){
				if($item['id'] == $ordersProduct['prod_id'] &&
				   $item['color_id'] == $ordersProduct['color_id'] &&
				   $item['size'] == $ordersProduct['size'])
				{
					$_SESSION['cart']['items'][$key]['qty'] = $ordersProduct['qty'];
				}	
			}
		}
		
		function removeItem($ordersProduct = array('prod_id'=>null, 'color_id'=>null)){
			foreach($_SESSION['cart']['items'] as $key=> $item){
				if($item['id'] == $ordersProduct['prod_id'] &&
				   $item['color_id'] == $ordersProduct['color_id'] &&
				   $item['size'] == $ordersProduct['size'])
				{
					unset($_SESSION['cart']['items'][$key]);
					unset($this->items[$key]);
				}	
			}
		}
		
		function removeUnavailableItems()
		{	foreach($this->items as $key=> $item){
				if(($item['thisItemStatus']['U'] || 
							($item['thisItemStatus']['B'] && !$item['thisItemStatus']['O']) || 
							($item['thisItemStatus']['AB'] && !$item['thisItemStatus']['O'])
				)) { 
					unset($_SESSION['cart']['items'][$key]);
					unset($this->items[$key]); 
				} 
			}
		}
		
		function clear(){
			$_SESSION['cart'] = array();
		}
		
		private function checkIfItemExists($product = array(), $size = null, $color_id = null){
			if(isset($_SESSION['cart']['items'])){
				foreach ($_SESSION['cart']['items'] as $key=>$item){
					if($item['id'] == $product['prod_id'] && $item['size'] == $size && $item['color_id'] == $color_id){
						return $key;
					}
				}
			}
			return false;
		}
		
		//set coupon application to cart items/ cart total here:
		function applyCouponDiscounts($coupons, $shippingType = null, $cartItems){
			$allTotals = array();
			$allTotals['shippingPrice'] = $this->totals['shippingPrice'];
			$allTotals['giftWrapTotal'] = $this->totals['giftWrapTotal'];
			$allTotals['noTaxNoShipping'] = $this->totals['noTaxNoShipping'];
			$this->totals['discount'] = $this->Coupon->applyCoupons($coupons, $shippingType, $cartItems, $allTotals);
			
			//recalculate grandtotal:
			$grandTotal = 0;
			if(array_sum($allTotals) - $this->totals['discount'] > 0){
				$grandTotal = array_sum($allTotals) - $this->totals['discount'];
			}else{
				//if discounts are greater than grand total,  then change discount to difference:
				$this->totals['discount'] = $this->totals['discount'] + (array_sum($allTotals) - $this->totals['discount']);
			}
			$this->totals['total'] = $grandTotal;
		}
		
    	private function getGiftWrapPrice(){
        	App::import('Model', 'GiftWrap');
            $GiftWrap = new GiftWrap();
        	$this->siteConfig->site_id;
        	$giftWrapPrice = $GiftWrap->findBySiteId($this->siteConfig->site_id);
        	return $giftWrapPrice['GiftWrap']['price_per_item'];
        }
}

?>