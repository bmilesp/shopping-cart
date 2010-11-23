<?php
App::import('Helper', 'Paginator');
class FormVariablesPaginatorHelper extends PaginatorHelper{

    function sort($title, $key = null, $options = array()) {
		$options = array_merge(array('url' => array(), 'model' => null), $options);

		if(isset($this->params['paging']['nonPaginatorArgs'])){
			$options['url'] = array_merge($this->params['paging']['nonPaginatorArgs'],$options['url']);
			return parent::sort($title,$key,$options);
		}else{
			///error
			//debug('Error: Must have PaginateFormVariables Component set in Controller');
		}
	}

	function prev($title = '<< Previous', $options = array(), $disabledTitle = null, $disabledOptions = array()) {
		$options = array_merge(array('url' => array()), $options);
		if(isset($this->params['paging']['nonPaginatorArgs'])){
			//$options['url'] = array_merge($this->params['paging']['nonPaginatorArgs'],$options['url']);
			return parent::prev($title, $options, $disabledTitle, $disabledOptions);
		}else{
			///error
			//debug('Error: Must have PaginateFormVariables Component set in Controller');
		}
	}

	function next($title = 'Next >>', $options = array(), $disabledTitle = null, $disabledOptions = array()) {
		$options = array_merge(array('url' => array()), $options);
		if(isset($this->params['paging']['nonPaginatorArgs'])){
			//$options['url'] = array_merge($this->params['paging']['nonPaginatorArgs'],$options['url']);
			return parent::next($title, $options, $disabledTitle, $disabledOptions);
		}else{
			///error
			//debug('Error: Must have PaginateFormVariables Component set in Controller');
		}
	}

	function numbers($options = array()) {
		$options = array_merge(array('url' => array()), $options);
		if(isset($this->params['paging']['nonPaginatorArgs'])){
			//$options['url'] = array_merge($this->params['paging']['nonPaginatorArgs'],$options['url']);
			return parent::numbers($options);
		}else{
			///error
			//debug('Error: Must have PaginateFormVariables Component set in Controller');
		}
	}
	
	function link($title, $url = array(), $options = array()) {
		//direct link shouldn't have a page arg:
		$this->params['paging']['nonPaginatorArgs']['page'] = null;
		
		$options = array_merge(array('url' => array()), $options);
		if(isset($this->params['paging']['nonPaginatorArgs'])){
			$url = array_merge($this->params['paging']['nonPaginatorArgs'],$url);
			return parent::link($title, $url, $options);
		}
	}
}
?>
