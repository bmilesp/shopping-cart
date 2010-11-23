<?php
class PaginateFormVariablesComponent extends Object {

	var $nonPaginatorArgs = array();

	function startup(&$controller) {
		$this->controller =& $controller;
	}

	function beforeRender(&$controller) {
		$this->controller->params['paging']['nonPaginatorArgs'] = $this->nonPaginatorArgs;
	}

	function shutdown(&$controller) {
	}

	//returns $nonPaginatorArgs for use with view $paginator
	function engage($defaultFormData = array(),$removeNullValues = true){
		//if filterNullValues = true, then filter:
		if($removeNullValues){
			$defaultFormData = $this->filterNullValues($defaultFormData);
			if(!empty($this->controller->data)){

				$this->controller->data = $this->filterNullValues($this->controller->data);
			}
		}

		///merge defaultFormData with post data (if any), else set to defaults:
		$this->controller->data = ($this->controller->data)? array_merge($defaultFormData, $this->controller->data) : $defaultFormData;

		//convert form data to passedArgs for paginate
		$this->nonPaginatorArgs = $this->convertDataToPassedArgs($this->controller->data);
		if(!empty($this->controller->passedArgs)){
			//if passedArgs exist, indicates a get request from the paginator.
			//convert back to $this->controller->data for form auto population, removing paginator vals
			$this->controller->passedArgs = array_merge($this->nonPaginatorArgs,$this->controller->passedArgs);
			$this->nonPaginatorArgs = $this->filterPaginatorArgs($this->controller->passedArgs);
			$this->controller->data = $this->convertPassedArgsToData($this->nonPaginatorArgs);
		}else{
			$this->controller->passedArgs = $this->nonPaginatorArgs;
		}
		$this->controller->paginateformVariables = $this->nonPaginatorArgs;
	}

	private function convertDataToPassedArgs($data = array()){
		$retArray = array();
		foreach($data as $bigKey=>$d){
			foreach($d as $key=>$val){
				$retArray[$bigKey.'.'.$key]=$val;
			}
		}
		return $retArray;
	}

	//must have keys be in Model.field format
	private function convertPassedArgsToData($args = array()){
		$args = $this->filterPaginatorArgs($args);
		$retArray = array();
		foreach($args as $key=>$arg){
			if(strpos($key, '.')){
				$splitter = split('\.',$key);
				$retArray[$splitter[0]][$splitter[1]] = $arg;
			}else{
				$retArray[$key] = $arg;
			}
		}
		return $retArray;
	}

	private function filterPaginatorArgs($args = array()){
		$retArray = array();
		foreach($args as $key=>$arg){
			if( !($key == 'page' || $key == 'sort' || $key == 'direction') || is_numeric($key) ){
				$retArray[$key] = $arg;
			}
		}
		return $retArray;
	}

	private function filterNullValues($args = array()){
		foreach($args as $bigKey=>$arg){
			if(is_array($arg)){
				foreach($arg as $key=>$val){
					if(empty($val)){
						unset($args[$bigKey][$key]);
					}
				}
			}
		}
		foreach($args as $bigKey=>$arg){
			if(empty($arg)){
				unset($args[$bigKey]);
			}
		}
		return $args;
	}

}
?>
