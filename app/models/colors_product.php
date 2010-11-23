<?php
class ColorsProduct extends AppModel {

	var $name = 'ColorsProduct';
	var $displayField = 'color';
	var $actsAs = 'Containable';

	var $belongsTo = array(
		'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'prod_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Color' => array(
			'className' => 'Color',
			'foreignKey' => 'color_id',
			'conditions' => '',
			'fields' => '', 
			'order' => ''
		)
	);
	
	function thisItemStatus($id,$size)
	{	$result = null;
		$skus = $this->getArrayOfSKUs($id);
		$colorsProduct = $this->findById($id);
		$thisSku = $this->checkAllFlags($skus[$size]);
		$result['B'] = $thisSku['B'];
		$result['AB'] = $thisSku['AB'];
		$result['U'] = $thisSku['U']; 
		$result['O'] = $colorsProduct['ColorsProduct']['override_backorder_status'];
		return $result;
	}
	
	function isBackordered($id,$size){
		$skus = $this->getArrayOfSKUs($id);
		$colorsProduct = $this->findById($id);
		$overrideBackorderStatus = $colorsProduct['ColorsProduct']['override_backorder_status'];
		return $this->checkBackorderedFlags($skus[$size],$overrideBackorderStatus);
	}
	
	function getArrayOfSKUs($id){
		$skukeys = array('OS', 'XXS', 'XS', 'S','M','L','XL','2XL','3XL', '4XL','5XL','6XL');
		$this->recursive = -1;
		$colorsProduct = $this->findById($id);
		$skus = array();
		foreach($skukeys as $skukey ){
			if($colorsProduct['ColorsProduct'][$skukey] != 0){
				$skus[$skukey] = $colorsProduct['ColorsProduct'][$skukey];
			}
		}
		return $skus;
	}
	
	function getBackorderSKUs($productSizes=array(), $overrideBackorderStatus = null, $checkOverrideStatus = true){//$productSizes returned from getArrayOfSKUs
		$backorderedSKUs = array();
		foreach ($productSizes as $size=>$sku){
			if($this->checkBackorderedFlags($sku, $overrideBackorderStatus, $checkOverrideStatus)){
				$backorderedSKUs[$size] = $sku; 
			}
		}
		return $backorderedSKUs;
	}
	
	function getUnavailableSKUs($productSizes=array(), $overrideBackorderStatus = null, $checkOverrideStatus = true){//$productSizes returned from getArrayOfSKUs
		$backorderedSKUs = array();
		foreach ($productSizes as $size=>$sku){
			if($this->checkUnavailableFlags($sku, $overrideBackorderStatus, $checkOverrideStatus)){
				$backorderedSKUs[$size] = $sku; 
			}
		}
		return $backorderedSKUs;
	}
	
	private function checkBackorderedFlags($SKU, $overrideBackorderStatus = null, $checkOverrideStatus = true){
		
		if($checkOverrideStatus){
			if( strstr($SKU, '_B') && !$overrideBackorderStatus ){
				return true;   	
			}
		}else{
			if( strstr($SKU, '_B') ){
					return true;   	
			}
		}
		return false;
	}
	
	private function checkUnavailableFlags($SKU, $overrideBackorderStatus = null, $checkOverrideStatus = true){ 
		
		if($checkOverrideStatus){
			if((strstr($SKU,'_U') || strstr($SKU,'_AB')) && !$overrideBackorderStatus){
				return true;
			}			
		}else{
			if( (strstr($SKU,'_U') || strstr($SKU,'_AB')) ){
					return true;   	
			}
		}
		return false;
	}
	
	function getSKUStatus($productSizes=array(), $overrideBackorderStatus = null)
	{
		$result = null;
		$backorderedSKUs = array();
		foreach ($productSizes as $size=>$sku){
			$thisSku = $this->checkAllFlags($sku);
			$result['B'][$size] = $thisSku['B'];
			$result['AB'][$size] = $thisSku['AB'];
			$result['U'][$size] = $thisSku['U']; 
			$result['O'][$size] = $overrideBackorderStatus;
		} 
		
		return $result;
	}
	
	private function checkAllFlags($SKU){ 
		$result['U'] = 0; $result['B'] = 0; $result['AB'] = 0;
		if(strstr($SKU,'_U')) { $result['U'] = 1; } 
		if(strstr($SKU,'_AB')) { $result['AB'] = 1; }
		if(strstr($SKU,'_B')) { $result['B'] = 1; }
		return $result;
	}
}
?>