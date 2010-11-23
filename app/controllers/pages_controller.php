<?php
/* SVN FILE: $Id$ */
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 */
class PagesController extends AppController {
/**
 * Controller name
 *
 * @var string
 * @access public
 */
	var $name = 'Pages';
/**
 * Default helper
 *
 * @var array
 * @access public
 */
	var $helpers = array('Html','Tagcloud');
/**
 * This controller does not use a model
 *
 * @var array
 * @access public
 */
	var $uses = array('Product', 'TagsProduct', 'Tag', 'SplashHeadlineImage','SplashSideBox','SplashPopularItem');
	
	function beforeFilter(){
		$this->Auth->allow('display');
		parent::beforeFilter();
		$this->set('title_for_layout', Inflector::humanize($this->params['pass'][0]));
	}
	
	
/**
 * Displays a view
 *
 * @param mixed What page to display
 * @access public
 */
	function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
		}
		$page = $subpage = $title = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title = Inflector::humanize($path[$count - 1]);
		}
		if($page == 'home'){
			$this->home();
		}
		if($page == 'testing'){
			$this->testing();
		}
		$this->set(compact('page', 'subpage', 'title'));
		$this->render(join('/', $path));
	}
	
	function home()
	{
		//debug(Router::url(array('controller'=>'products', 'action'=>'index',211)));
		$scoreCloud = array();
		$nameCloud = array();
		$tagCloudSet = $this->siteConfig->getCartDBField('tag_cloud');
		if($tagCloudSet){
			$possibleTags = $this->Tag->find('list',array('conditions'=>array('site_id'=>$this->siteConfig->site_id),
														  'fields'=>array('tag_id','tag_id')));
			$tags = $this->TagsProduct->find('all', array('conditions'=>array('TagsProduct.tag_id'=>$possibleTags),
														  'fields'=>array('*','count(*) as score'), 
													      'group'=>array('TagsProduct.tag_id having COUNT( * ) >1'), 
													      'limit'=>30,
														  'recursive'=>1
											)); 
	
									
			$scoreCloud = array_combine(
					Set::extract($tags, '{n}.Tag.tag_id'),
					Set::extract($tags, '{n}.0.score')
					
			);
			$nameCloud = array_combine(
						Set::extract($tags, '{n}.Tag.tag_id'),
						Set::extract($tags, '{n}.Tag.name')
						
			);
		}
		
		$products = $this->Product->find('all',
										  array('contain' =>array('ColorsProduct' =>array('color_id','color','is_base','Color'),
																  'Image'=>array('Upload','conditions'=>array('Image.type'=>'Overlay'))),
											    'conditions'=>array('active'=>1,'site_id'=>$this->siteConfig->site_id),
											    'order' => 'daOrder ASC'
												));
		$headlineImages = $this->SplashHeadlineImage->find('all',array('conditions'=>array('live'=>1,'SplashHeadlineImage.site_id'=>$this->siteConfig->site_id)));
		$popularProducts = $this->SplashPopularItem->find('all',array('conditions'=>array('SplashPopularItem.site_id'=>$this->siteConfig->site_id, 'Product.active'=>1),
																	  'contain'=> array('Product'=>array('ColorsProduct' =>array('color_id','color','is_base')))));
		$sideBoxes = $this->SplashSideBox->find('all',array('conditions'=>array('live'=>1, 'SplashSideBox.site_id'=>$this->siteConfig->site_id)));
		$this->set(compact('scoreCloud','nameCloud','popularProducts','sideBoxes','headlineImages','tagCloudSet','products'));
	}
	
	function testing(){
	 	var_dump($_SESSION);
		var_dump($session);
	}
	
	function what_are()
	{}
}

?>