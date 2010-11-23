<?php
class ProductsController extends AppController {

	var $name = 'Products';
	var $helpers = array('Html', 'Form', 'FormVariablesPaginator');
	var $components = array('Cart','Transporter', 'RequestHandler', 'PaginateFormVariables');
	var $uses = array('Product','ColorsProduct','Tag');
	var $paginateItems = 18;

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('index', 'view', 'search', 'tags','tags_original');
		$this->layout = 'sidebar';
		if( (isset( $this->params['named']['pages']) && $this->params['named']['pages'] == 'showAll') || (isset($this->theme) && $this->theme == 'original')){
			$this->paginateItems = 1000;
		}
	}

	function index() {
		$this->paginate = array(
		  		'Product'=>array(
		  			 'contain' => array('ColorsProduct' =>array('color_id','color','is_base','Color'),
										'Image'=>array('Upload','conditions'=>array('Image.type'=>'Overlay'))),
					 'limit' => $this->paginateItems,
			  		 'conditions'=>array('active'=>1,'site_id'=>$this->siteConfig->site_id),
					 'order' => 'daOrder ASC'
				)
		);
		
		//get all related tags.. derp de derp
		$relatedTags = $this->Tag->findAllNonGroupTags($this->siteConfig->site_id);
	
		
		$defaultFormData = array(); 					
		//run the form vals component. This component will convert $this->data 	
		// to $this->passedArgs and vice-versa where appropriate, and will also pass non- 	
		// paginator arguments (args from the form): 		
		$this->PaginateFormVariables->engage($defaultFormData,false); 
		//after defaults are set and $this->PaginateFormVariables->engage is ran, set your get/post data to paginationConditions:
		$paginationConditions = array(); 							
		$products = $this->paginate('Product',$paginationConditions);
		$this->set(compact('products','relatedTags'));
	}

	function view($productId,$colorId){
		
		///can make it not use curl by adding models etc. later....
		
		if($_SERVER['HTTP_HOST'] == 'localhost'){
			$host = 'localhost/';
		}	
		$checkInventoryCurl = curl_init();
		$invCheckUrl = "http://{$host}admin.undergroundshirts.com/c/retail_inventory/checkProductBackorders/$productId/$colorId";
		curl_setopt($checkInventoryCurl, CURLOPT_URL, $invCheckUrl);
		curl_setopt($checkInventoryCurl, CURLOPT_HEADER, 0);
		//comment out below option if you want to see CURL output:
		curl_setopt($checkInventoryCurl, CURLOPT_RETURNTRANSFER, true);
		$returnVar = curl_exec($checkInventoryCurl);
		curl_close($checkInventoryCurl);
		
		/////////////////////////////////////////////////////////
		
		$this->layout = 'default';
		$this->ColorsProduct->Contain(array('Product'=>array('ShippingGroup'),
											'Color'));
		$product = $this->ColorsProduct->find('first',array('conditions'=>array(
																'prod_id'=>$productId,
																'color_id'=>$colorId,
																'Product.active'=>1)));
		$this->ColorsProduct->Contain(array('Color'));
		$colors = $this->ColorsProduct->find('all',array('conditions'=>array(
																'prod_id'=>$productId)));
		if(!empty($product)){
			$similarProducts = null;
			$product['pics'] = $this->Product->sortPicsInArray($product);
			$product['sizes'] = $this->ColorsProduct->getArrayOfSKUs($product['ColorsProduct']['id']);
			$product['backorderSkus'] = $this->ColorsProduct->getBackorderSKUs($product['sizes'],$product['ColorsProduct']['override_backorder_status']);
			$product['unavailableSkus'] = $this->ColorsProduct->getUnavailableSKUs($product['sizes'],$product['ColorsProduct']['override_backorder_status']);
			$product['allSkusStatus'] = $this->ColorsProduct->getSKUStatus($product['sizes'],$product['ColorsProduct']['override_backorder_status']);
			$socialURL = $this->http."://".$_SERVER['HTTP_HOST'].$this->here;
			//comment out below option if you want to see CURL output:
			//curl_setopt($cCurl, CURLOPT_RETURNTRANSFER, true);
			$bitlyURL = file_get_contents("http://api.bit.ly/v3/shorten?login=ugpbitly&apiKey=R_cdf71a64a278d69f00e2799788cad6be&longUrl=".urlencode($socialURL)."&format=txt");
			$pageTitle =  urldecode($product['Product']['name'])." - ".$product['Color']['color'];
			$this->set('title_for_layout',$pageTitle);
			$this->set(compact('productId', 'colorId', 'product', 'colors','similarProducts','bitlyURL','socialURL','pageTitle'));
		}else{
			$this->Session->setFlash(__("The product you are looking for does not exist or is no longer available.", true));
			$this->redirect(array('controller'=>'products','action'=>'index'));
		}
	}
	
	function search(){
		
		$this->paginate = array(
		  		'Product'=>array(
		  			 'contain' => array('ColorsProduct' =>array('color_id','color','is_base','Color'),
										'Image'=>array('Upload','conditions'=>array('Image.type'=>'Overlay'))),
					 'limit' => $this->paginateItems,
			  		 'conditions'=>array('active'=>1,'site_id'=>$this->siteConfig->site_id),
					 'order' => 'daOrder ASC'
				)
		);

		$defaultFormData = array(); 		
		$defaultFormData['Product']['search'] = ''; 		
	 		
		//run the form vals component. This component will convert $this->data 	
		// to $this->passedArgs and vice-versa where appropriate, and will also pass non- 	
		// paginator arguments (args from the form): 		
		$this->PaginateFormVariables->engage($defaultFormData,false);

		$searchString = trim(ereg_replace("[^a-zA-Z0-9/#/&/+/$/@/! ]",'',$this->data['Product']['search']));
		$searchBitsArray = split(" ",$searchString);
		$searchBits = array();
		foreach ($searchBitsArray as $bit){
			$searchBits[] = array('name LIKE'=>'%'.$bit.'%', 'active'=>1, 'site_id' => $this->siteConfig->site_id );
			$searchBits[] =	array('message LIKE'=>'%'.$bit.'%', 'active'=>1, 'site_id' => $this->siteConfig->site_id );
			$searchBits[] =	array('message2 LIKE'=>'%'.$bit.'%', 'active'=>1, 'site_id' => $this->siteConfig->site_id );
			$searchBits[] =	array('url_tags LIKE'=>'%'.$bit.'%', 'active'=>1, 'site_id' => $this->siteConfig->site_id );
		}
		$paginationConditions = array(); 
		$paginationConditions['OR'] = $searchBits; 					
		$products = $this->paginate('Product',$paginationConditions);
		$this->set(compact('products'));
		$this->set('title_for_layout', Inflector::humanize($searchString));
	}
	
	function tags(){
		$verifiedTags = $this->Tag->findVerifiedTagList($this->params['pass'], $this->siteConfig->site_id);
		$tagProducts = array();
		if(!empty($verifiedTags)){
			$tagIDList = array_keys($verifiedTags);
			$selectedTagId = $tagIDList[0];
			$tagProductIds = $this->Tag->findProductIdsByTags($tagIDList,$this->siteConfig->site_id);
		}
		
		//for use in side_bar_nav.ctp:
		$selectedGroup = $this->Tag->findFirstSelectedGroup($verifiedTags);
		$relatedTags = array();
		if(count($verifiedTags) > 1){
			$relatedTags = $this->Tag->findRelatedTags($tagProductIds);
		}
		
		
		$this->paginate = array(
		  		'Product'=>array(
		  			 'contain' => array('ColorsProduct' =>array('color_id','color','is_base','Color'),
										'Image'=>array('Upload','conditions'=>array('Image.type'=>'Overlay'))),
					 'limit' => $this->paginateItems,
			  		 'conditions'=>array('active'=>1,'site_id'=>$this->siteConfig->site_id, 'id'=>$tagProductIds),
					 'order' => 'daOrder ASC'
				)
		);
		$defaultFormData = array();
		$this->PaginateFormVariables->engage($defaultFormData,false); 
		$products = $this->paginate('Product');
		$this->set('title_for_layout', Inflector::humanize(implode(' ',$verifiedTags)));
		$this->set(compact('products','verifiedTags','selectedGroup','relatedTags','selectedTagId'));
		
	}
	
	private function findMatchingArray( $needle, $haystack ) {
	    foreach( $needle as $element ) {
	        $test_element = (array) $element;
	        if( count( $test_element ) == count( array_intersect( $test_element, $haystack ) ) ) {
	            return $element;
	        }
	
	    }
	    return false;
	} 
}
?>
