<?php 

class TaxComponent extends Object {
    
		var $Zip2Tax;//required model
		var $State;//required model
		var $Store;//required model
		var $sum_taxable = 0;
		var $sub_total = 0;
		
        function initialize() { 
            App::import('Model', 'State');
            $this->State = new State();
            App::import('Model', 'Store');
            $this->Store = new Store();
            App::import('Model', 'Zip2Tax');
            $this->Zip2Tax = new Zip2Tax();
        }
        
        function getTaxRateByZip($zip){
        	$stores = $this->Store->find('all',array('fields'=>array('DISTINCT state')));
        	//add tax only if we have a store in that state
        	$IN = Set::extract($stores, '{n}.Store.state');
        	$rate = $this->Zip2Tax->find('first',array('conditions'=>array('zip'=>$zip ,'state'=>$IN),
        									    'fields'=>array('rate','state')));
        	return $rate['Zip2Tax']['rate'];
        }
        
        function isApparelTaxable($is_apparel = 0, $state){
        	$taxRecord = $this->State->findByStateCode($state);
        	if(!empty($taxRecord)){
	        	$apparel_field = ($is_apparel)? "tax_apparel" : "non_tax_apparel";
	        	return $taxRecord['State'][$apparel_field];
        	}
        	return false;
        }
        
        function applyTaxByZip($amtToTax, $zip){
        	$taxRate = ($this->getTaxRateByZip($zip)/100);
			$tax = $taxRate * $amtToTax;
			if($tax < 0){
				$tax = 0;
			}
			return $tax;
        }
        
}        
?>