<?php 
$jscode = 
<<<EOJAVASCRIPT
	$(document).ready(init);
	
	function init(){
		$('.product_rollover').bind('mouseenter',product_rollover_mouseenter);
		$('.product_rollover').bind('mouseleave',product_rollover_mouseleave);
		
	}

	function product_rollover_mouseenter(e){
		$(this).find('.overlay_swatch_wrapper').stop().fadeTo(200,1);
		$(this).find('.product_pricing').removeClass('product_pricing_info');
		$(this).find('.product_pricing').addClass('product_pricing_info_hover');
		$(this).find('.overlay_img_wrapper').stop().fadeTo(200,1);
		$(this).find('.base_img_wrapper img').stop().fadeTo(600,0);
	}
	
	function product_rollover_mouseleave(e){
		$(this).find('.overlay_swatch_wrapper').stop().fadeTo(600,0);
		$(this).find('.product_pricing').addClass('product_pricing_info');
		$(this).find('.product_pricing').removeClass('product_pricing_info_hover');
		$(this).find('.overlay_img_wrapper').stop().fadeTo(600,0);
		$(this).find('.base_img_wrapper img').stop().fadeTo(600,100);
	}

EOJAVASCRIPT;

echo $javascript->codeBlock($jscode, array('inline'=>false));
//debug($product);
?>
<div class="product_display product_rollover">
	<div class="product_display base_img_wrapper">
		<div class='product_shadow_background'>
			<img style="background-image:url('<?php echo $cartsAdminUrl?>c/img/<?php echo $images['Background']['Upload']['name']?>')" class="pic_table_img product_display" src="https://carts.undergroundshirts.com/prod_img/position_1/<?php echo $product['Product']['id']?>_<?php echo $product['ColorsProduct'][0]['color_id']?>.jpg" />
		</div>
		<div class="product_pricing product_pricing_info">
			<?php 	
				$productName =  strtoupper(urldecode($product['Product']['name']));
				echo str_replace(" ","&nbsp;",substr($productName,0,23)); echo (strlen($productName) > 23)? '...' : null?>
			<h5><?php echo str_replace(" ","&nbsp;",strtoupper(urldecode($product['Product']['garment_type']))) ?></h5>
		</div>
	</div>
	<div class="product_display overlay_img_wrapper">
		<?php if($product['Product']['pic2'] == 1){
				$img = $this->Html->image("https://carts.undergroundshirts.com/prod_img/position_2/{$product['Product']['id']}_{$product['ColorsProduct'][0]['color_id']}.jpg",array(
										  'style'=>"background-image:url('{$cartsAdminUrl}c/img/{$images['Background']['Upload']['name']}')",
										  'class'=>'pic_table_img_top'));
			}else{
				$img = $this->Html->image("https://carts.undergroundshirts.com/prod_img/position_1/{$product['Product']['id']}_{$product['ColorsProduct'][0]['color_id']}.jpg",array(
										  'style'=>"background-image:url('{$cartsAdminUrl}c/img/{$images['Background']['Upload']['name']}')",
										  'class'=>'pic_table_img_top')); 
			} 
			echo $this->Html->link($img,array('controller'=>'products',
											  'action'=>'view',$product['Product']['id'],$product['ColorsProduct'][0]['color_id']),
										array('escape'=>false));
			?>
	</div>
	<?php 
		if(isset($product['Image'][0]['Upload']['name'])){ 
			$content = $this->Html->image("https://carts.undergroundshirts.com/c/img/{$product['Image'][0]['Upload']['name']}", 
										  array('width'=>'200px','height'=>'200px'));	
		}else{
			$content = '<div style="width:200px;height:200px;border:none">&nbsp;</div>';
		}
		$innerLink =  $this->Html->link($content,array('controller'=>'products',
													   'action'=>'view',$product['Product']['id'],$product['ColorsProduct'][0]['color_id']),
												 array('escape'=>false));
		$divContent = '<div class="overlay_stickers"><div class="overlay_image">'.$innerLink.'</div></div>';
		echo $this->Html->link($divContent,array('controller'=>'products',
												 'action'=>'view',$product['Product']['id'],$product['ColorsProduct'][0]['color_id']),
										   array('escape'=>false));
	?>
	<div class="overlay_swatch_wrapper">
			<?php if(!empty($product['ColorsProduct'][0]['Color'])){?>
			<div class='color_overlay_swatches_extra_boarder'>
				<div class='color_overlay_swatches'>	
					<?php foreach($product['ColorsProduct'] as $colorProduct){
						$img = $this->Html->image("http://catalog.undergroundshirts.com/swatches/{$colorProduct['Color']['filename']}",
												  array('width'=>'10', 'alt'=>$colorProduct['color']));
						echo $this->Html->link($img,array('controller'=>'products',
														  'action'=>'view',$product['Product']['id'],$product['ColorsProduct'][0]['color_id']),
													array('escape'=>false, 'title'=>$colorProduct['color']));
					}?>
				</div>
			</div>
			<?php }?>
		</div>
	
</div>