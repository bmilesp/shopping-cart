<?php
class Holiday extends AppModel {

	var $name = 'Holiday';
	var $useDbConfig = 'admin';
	var $useTable = 'TT_holiday';
	var $actsAs = array('Containable');
	var $displayField = 'holiday_date';
	
	function nextBusinessDay($date, $includeSaturday = false){ 
		switch(date("N",strtotime($date)) > '5'){
			case '6':
				if(!$includeSaturday){
					$date=date('Y-m-d',strtotime("+2days",strtotime($date)));
				}
			break;
			case '7':
				$date=date('Y-m-d',strtotime("+1day",strtotime($date)));
			break;
		}
		$holidays = $this->find('list');
		foreach($holidays as $holiday){
			if(strtotime($date) == strtotime($holiday)){
				return $this->nextBusinessDay( date('Y-m-d',strtotime("+1day",strtotime($date))) );
			}
		}
		return $date;				
    }

}
?>