<?php
/* SVN FILE: $Id$ */
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @subpackage    cake.cake.libs.controller
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * This is a placeholder class.
 * Create the same file in app/app_controller.php
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 */
class AppController extends Controller 
{
	var $helpers = array('Ajax', 'Javascript','Session');
	var $components = array('Auth','AutoLogin','Session','Cart','RequestHandler');
	var $uses = array('Maintenance','Coupon','Group','Image');
	var $rootDir = null;
	var $baseFilePath = null;
	var $secureRootDir = null;
	var $cartsAdminUrl = null;
	var $authUser = null;
	var $siteConfig = null;
	var $browser = null;
	var $prod_img_url = 'https://carts.undergroundshirts.com/prod_img';
	var $http = 'http';
	var $images = array();
	var $view = 'Theme';


	
	function beforeFilter(){
		///check if server uses a trailing slash in DOCUMENT_ROOT:
		$lastpos = strlen($_SERVER['DOCUMENT_ROOT']) -1;
		$poslash = substr($_SERVER['DOCUMENT_ROOT'], $lastpos);
		if($poslash === "/"){
			$docRoot = $_SERVER['DOCUMENT_ROOT'];
		}else{
			$docRoot = $_SERVER['DOCUMENT_ROOT']."/";
		}
		$this->baseFilePath = $docRoot.substr($this->base,1);
		
		App::import('Vendor', 'connections');
		App::import('Vendor', 'browser');
		$this->siteConfig = new Connections();
		$this->browser = new Browser();
		
		$this->setTheme();
		
		$this->set('browser', $this->browser);
		$this->set('siteConfig', $this->siteConfig);
		
		//check if maintenence.active is 0, else disable site{
		$maint = $this->Maintenance->findBySiteId($this->siteConfig->site_id);
		if($maint['Maintenance']['active'] == 1){
			$this->autoRender = false;
			echo "<div style='width: 100%; height: 10px; background: #fff; position: relative; top: -.5em;'></div><center><h1>THIS SITE IS UNDERGOING SCHEDULED MAINTENANCE</h1><Br><h2>Sorry for the inconvenience.</h2></center>";
			die;
		}	
		//set rootDir
		$http = (isset($_SERVER['HTTPS']))? 'https' : 'http';
		if($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST']=="192.168.1.107"){
			$rootDir = split("/",$this->base);
			$this->rootDir = "http://{$_SERVER['HTTP_HOST']}/{$rootDir[1]}/";
			$this->rootDirNoTrailingSlash = "http://{$_SERVER['HTTP_HOST']}/{$rootDir[1]}";
			$this->secureRootDir = "http://{$_SERVER['HTTP_HOST']}/{$rootDir[1]}/";
			$this->cartsAdminUrl = "{$http}://{$_SERVER['HTTP_HOST']}/carts.undergroundshirts.com/";
		}else{
			
			$base = $this->base;
			if(strpos($this->base,'/') === 0){ 
				$base = $this->base;
			}else{
				if($this->base){
					$base = "/".$this->base;
				}
			}
			$lastpos = strlen($_SERVER['HTTP_HOST']) -1;
			$poslash = substr($_SERVER['HTTP_HOST'], $lastpos);
			if($poslash === "/"){
				$docHost = substr($_SERVER['HTTP_HOST'],0, $lastpos);
			}else{
				$docHost = $_SERVER['HTTP_HOST'];
			}
			$this->rootDir = "http://{$docHost}".$base."/";
			$this->rootDirNoTrailingSlash = "http://{$docHost}".$base;
			$this->secureRootDir = "https://{$docHost}".$base."/";
			$this->cartsAdminUrl = "{$http}://carts.undergroundshirts.com/";
		}
		$this->http = $http;
		$rootDir = $this->rootDir;
		$secureRootDir = $this->secureRootDir;
		$cartsAdminUrl = $this->cartsAdminUrl;
		$prodImgUrl = $this->prod_img_url;
		$baseFilePath = $this->baseFilePath;
		$rootDirNoTrailingSlash = $this->rootDirNoTrailingSlash;
		$this->set(compact('rootDir', 'secureRootDir', 'prodImgUrl','http','baseFilePath', 'cartsAdminUrl', 'rootDirNoTrailingSlash'));
		$this->Auth->sessionKey = 'User';		
		$this->Auth->fields = array('username' => 'email', 'password' => 'retail_password');
		//$this->Auth->loginAction = array('controller' => 'users', 'action' => 'add');
		$this->Auth->loginError = 'Incorrect username and/or password. Please try again.';
		$this->Auth->loginRedirect = $this->rootDir;
		$this->Auth->autoRedirect = false;
		$this->Auth->authorize = 'controller';
		if($authUser = $this->Auth->user()){
			$this->authUser = $authUser['User'];
		}
		$this->set('authUser', $this->authUser);
		///get top_menu_nav 
		$mainMenuGroups = $this->Group->findMenuGroups($this->siteConfig->site_id);
		$sidebarGroups = $this->Group->findMenuGroups($this->siteConfig->site_id, 'side_bar');
		$siteMapGroups = $this->Group->findMenuGroups($this->siteConfig->site_id, 'site_map');
		$this->set(compact('mainMenuGroups', 'sidebarGroups', 'siteMapGroups'));
		
		//get images
		$this->images['Background'] = $this->Image->find('first',array('conditions'=>array('site_id'=>$this->siteConfig->site_id, 'Image.type'=>'Background'),
																		'recursive'=>1));
		$images = $this->images;
		$this->set(compact('images'));
	}
	

	function beforeRender(){
		//use different layout for cake errors
		if($this->name == 'CakeError'){
			//$this->layout = 'error';
		}
		//set cart
		$cartItems = $this->Cart->items;
		$coupons = $this->Coupon->getCoupons($this->Cart->items, $this->Cart->totals['noTaxNoShipping']);
		$this->Cart->applyCouponDiscounts($coupons, 1, $cartItems);
		$cartItemImageUrl = $this->Cart->itemImageUrl;
		$cartTotals = $this->Cart->totals; 
		//debug($cartTotals);
		$this->set(compact('cartItems', 'coupons', 'cartItemImageUrl', 'cartTotals'));
	}
	
	function sessionSelected($key,$val){
		if( isset($_SESSION['Selected']) && !empty($_SESSION['Selected']) ){
			$_SESSION['Selected'][$key] = $val;
		}else{
			$_SESSION['Selected'] = array($key => $val);
		}
	}
	
	function isAuthorized(){return true;}//user controller needs this for guest user
	
	
	function authGuestDeny(){
		$actions = func_get_args();
		$user = $this->Auth->User();
		if(!empty($user)){
			if($user['User']['cart_guest']){
				foreach ($actions as $action) {
					if($action == $this->action){
						return false;
					}
				}
			}
		}
		return true;
	}
	
	function setTheme(){
		//used for jalen tag in header:
		$prefix = $this->getUrlPrefixes();
		$this->set(compact('prefix'));
		
		$theme = $this->siteConfig->getCartDBField('theme');
		if($theme){
			$this->theme = $theme;
		}
	}
	
	function getUrlPrefixes(){
		$prefixes = Configure::read('Routing.prefixes');
		$possibleUrlPrefixes = split("/",$_SERVER['REQUEST_URI']);
		foreach ($possibleUrlPrefixes as $possiblePrefix){
			foreach ($prefixes as $prefix){
				if ($prefix == $possiblePrefix){
					return $prefix;
				}
			}	
		}
		return null;
	}
	
	function https($url = null){
		$url = Router::url($url, true);
		if($_SERVER['HTTP_HOST'] != 'localhost'){
			$url =  str_replace('http:','https:',$url);
		}
		return $url;
	}
	

	
}
?>