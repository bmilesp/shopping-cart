<?php 
	$html->css('jquery.lightbox-0.5',null,array('inline'=>false));
	$javascript->link('jquery.tools.1.1.2.min.js',false);

$jscode = 
<<<EOJAVASCRIPT
// execute your scripts when the DOM is ready. this is mostly a good habit
$(function() {

	// initialize scrollable
	$(".scrollable").scrollable();

});

EOJAVASCRIPT;
$javascript->codeBlock($jscode, array('inline'=>false));
$html->css('popular_items',null,array('inline'=>false));
?>

<div id="scrollableWrapper">
<a class="prev browse left"></a>

<!-- root element for scrollable -->
<div class="scrollable">   
   
   <!-- root element for the items -->
   <div class="items">
   		<div>
	   	<?php $i=0;
	   		  $itemsPerScroll = 4; 
	   		  foreach ($popularProducts as $product){
	      		if($i %  $itemsPerScroll == 0 && $i != 0){?>
      	</div>
      	<div>
	      		<?php } 
	      		echo $html->image("https://carts.undergroundshirts.com/prod_img/position_1/{$product['Product']['id']}_{$product['Product']['ColorsProduct'][0]['color_id']}.jpg",
	      					 array('url'=>array('controller'=>'products','action'=>'view',$product['Product']['id'],$product['Product']['ColorsProduct'][0]['color_id'])));
	     	  $i++;}?>
   		</div>
   </div>
   
</div>

<!-- "next page" action -->
<a class="next browse right"></a>
<div style="clear:both"></div>
</div>


