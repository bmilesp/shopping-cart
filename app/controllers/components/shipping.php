<?php 

class ShippingComponent extends Object {
	
	var $ShippingAddress = null;
	var $ShippingCode = null;
	
	var $shippingCodes = array();
	var $Ups = null;
	

	function initialize(){
		App::import('Vendor', 'Ups');
        $this->Ups = new Ups();
        App::import('Model', 'ShippingCode');
        $this->ShippingCode = new ShippingCode();
        App::import('Model', 'ShippingAddress');
        $this->ShippingAddress = new ShippingAddress();
        App::import('Model', 'Holiday');
        $this->Holiday = new Holiday();
        $shippingCodes = $this->ShippingCode -> find('all');
        //set up shipping code array keys as primary key
        $this->shippingCodes = array_combine(Set::extract($shippingCodes, '{n}.ShippingCode.id'),
											 Set::extract($shippingCodes, '{n}.ShippingCode')
											 );
	}
	
	function getShippingAddress($shippingAddressId)
	{
		return $this->ShippingAddress->findByShipId($shippingAddressId);
	}
	
	function getShippingPrice($shippingType, $shippingAddressId, $cartItems)
	{
		$shippingPrice = 0;
		$shippingAddress = $this->getShippingAddress($shippingAddressId);
		switch($shippingType){
			case 1://usps
				$shippingPrice = $this->getUspsPrice($cartItems);
			break;
			default:// ups ground ups_2_day_air ups_next_day_air
				$weight = $this->getTotalWeight($cartItems);
				$code = $this->shippingCodes[$shippingType]['shippers_cost_code'];
				$end_zip = $shippingAddress['ShippingAddress']['zip'];
				$shippingPrice = $this->Ups->getShippingPrice("48103", $end_zip, $code, $weight, 18, 13, 3);
			break;
		}
		return $shippingPrice;
	}
	
	function getShipDates($shippingType, $shippingAddressId, $cartItems)
	{
		//check if backordered
		$addShipDays = 0;
		foreach($cartItems as $item){
        	if($item['isBackordered']){
        		$addShipDays = 10;
        	}
        }
        $shipDates = $this->getShipDate($addShipDays);
        
        switch($shippingType){
			case 1://usps
				$transitDays = 10;
				$inHandsDate = date("Y-m-d",strtotime($shipDates['UPSFormat']) + ($transitDays * 86400));
			break;
			default:// ups ground ups_2_day_air ups_next_day_air
				$shippingAddress = $this->ShippingAddress->findByShipId($shippingAddressId);
				$code = $this->shippingCodes[$shippingType]['shippers_cost_code'];
				$end_zip = $shippingAddress['ShippingAddress']['zip'];
				$toCityName = $shippingAddress['ShippingAddress']['city'];
				$transitDays =  $this->Ups->ups_transit($code, 48103, "Ann Arbor", $end_zip, $toCityName, $shipDates['UPSFormat']);
				if($transitDays === ''){
					$transitDays = 10;
				}else if ($transitDays === 0){
					$transitDays = 1;
				}
				$inHandsDate = date("Y-m-d",strtotime($shipDates['UPSFormat']) + ($transitDays * 86400));
				
			break;
        }
        $inHandsDate = $this->Holiday->nextBusinessDay($inHandsDate);
		return array('inHandsDate'=>$inHandsDate,'shipDate'=>$shipDates['UGPFormat']);
	}
	
	/**
	 * gets a list of shipping methods for use in a select box
	 * 
	 * @param $shippingAddressId
	 * @param $cartItems
	 */
	
	function findPossibleShippingMethods($shippingAddressId, $cartItems){
		Uses('Xml');
		$shippingAddress = $this->ShippingAddress->findByShipId($shippingAddressId);
		$weight = $this->getTotalWeight($cartItems);
		$end_zip = $shippingAddress['ShippingAddress']['zip'];
		$toCityName = $shippingAddress['ShippingAddress']['city'];
		$shipDates = $this->getShipDate(0);
		$upsRaw = $this->Ups->ups_transit('03',"48103", "Ann Arbor", $end_zip, $toCityName, $shipDates['UPSFormat'], true);
		$upsXml = new Xml($upsRaw);
		$upsArray = Set::reverse($upsXml);
		$shippingMethodList = array_combine(
			Set::extract('TimeInTransitResponse.TransitResponse.ServiceSummary.{n}.Service.Code',$upsArray),
			Set::extract('TimeInTransitResponse.TransitResponse.ServiceSummary.{n}.Service.Description',$upsArray)
		); 
		
		//ADD USPS To Possible shipping method list
		$shippingMethodList['USPS'] = 'USPS';

		//get a list of shipping methods we offer then filter out un-offered shipping methods:
		$offeredShippingMethods = $this->ShippingCode->find('list', array('conditions'=>array('in_carts'=>1),
																		  'fields'=>array('ShippingCode.request_return_code','ShippingCode.title')));
		$filteredShippingMethods = array_intersect($offeredShippingMethods,$shippingMethodList);
		
		//get list with primary_keys:
		$filteredList = $this->ShippingCode->find('list', array('conditions'=>array('in_carts'=>1,'request_return_code'=>array_keys($filteredShippingMethods))));
		return $filteredList;
	}
	
	
	function getUspsPrice($cartItems = array())
	{
		$totalUspsPrice = 0;
		foreach ($cartItems as $item){
			$totalUspsPrice += $item['usps_price'] * $item['qty'];
		}
		return $totalUspsPrice;
	}
	
	function getTotalWeight($cartItems = array())
	{
		$totalWeight = 0;
		foreach ($cartItems as $item){
			$totalWeight += $item['weight'] * $item['qty'];
		}
		return $totalWeight;
	}
	
	
	private function getShipDate($addDays = 0){		
		$ship_hour = date('H');
	  	if ($ship_hour >= 12 && $addDays == 0) //noon
	  	{    
	  		$addDays = 1;
	  	}
	  	$UPSFormat = date('Ymd', mktime(0, 0, 0, date("m"), date("d")+$addDays, date("Y")));
	  	$UGPFormat =  date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")+$addDays, date("Y")));
		return array('UPSFormat'=>$UPSFormat, 'UGPFormat'=>$UGPFormat);
	}
	
	
}
?>