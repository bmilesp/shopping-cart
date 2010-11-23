<?php
/* SVN FILE: $Id$ */
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.model
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Application model for Cake.
 *
 * This is a placeholder class.
 * Create the same file in app/app_model.php
 * Add your application-wide methods to the class, your models will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.model
 */
class AppModel extends Model {
	
	///// custom validation methods //////
	function authenticateUserAndData($check){ 
		if(!is_array($check)){//for easy use in a controller
			$check = array('user_id'=>$check);
		}
		$loggedInUser = isset($_SESSION['User']['id'])? $_SESSION['User']['id'] : null;
		if($loggedInUser){
			if($loggedInUser == $check['user_id']){
				return true;
			}
		}
		return false;
	}
	//end custom validation methods//
	
	
	function softDelete($id){
		$this->read(null,$id);
		if($this->data[$this->name]['user_id'] == $_SESSION['User']['id']){
			$this->set('display', 0);
			$this->save();
			return true;
		}
		return false;
	}
	
	function removeValidationRule($fieldname = 'email',$rulename = 'unique'){
		if(isset($this->validate[$fieldname][$rulename] )){
			unset( $this->validate[$fieldname][$rulename] );	
		}else{
			//find array value
			$key = array_search($rulename, $this->validate[$fieldname]);
			if($key > -1){
				unset($this->validate[$fieldname][$key]);
			}
		}
		
	}
	
}
?>