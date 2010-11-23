
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
				<?php if($product['Product']['was_price'] > 0){ ?>
					<span class='wasPrice'>
						<?php echo $html->image('slash.png',array('class'=>'wasPriceSlash'))?>
						<strong>Was: $<?php echo number_format($product['Product']['was_price'],2) ?></strong>
					</span>  		
				<?php } ?>
				<div style="clear:both"><strong><?php echo ($product['Product']['was_price'] > 0)? 'Now Only:': '';?> $<?php echo number_format($product['Product']['price'],2) ?></strong></div>
				
		</div>
	</div>
	<div class="product_display overlay_img_wrapper">
		<a href="<?php echo $rootDir ?>products/view/<?php echo $product['Product']['id'] ?>/<?php echo $product['ColorsProduct'][0]['color_id'] ?>">
			<?php if($product['Product']['pic2'] == 1){?>
				<img style="background-image:url('<?php echo $cartsAdminUrl?>c/img/<?php echo $images['Background']['Upload']['name']?>')" class="pic_table_img_top" src="https://carts.undergroundshirts.com/prod_img/position_2/<?php echo $product['Product']['id']?>_<?php echo $product['ColorsProduct'][0]['color_id']?>.jpg" />
			<?php }else{ ?>
				<img style="background-image:url('<?php echo $cartsAdminUrl?>c/img/<?php echo $images['Background']['Upload']['name']?>')" class="pic_table_img_top" src="https://carts.undergroundshirts.com/prod_img/position_1/<?php echo $product['Product']['id']?>_<?php echo $product['ColorsProduct'][0]['color_id']?>.jpg" />			
			<?php } ?>
		</a>
	</div>
	<a href="<?php echo $rootDir ?>products/view/<?php echo $product['Product']['id'] ?>/<?php echo $product['ColorsProduct'][0]['color_id'] ?>">
		<div class="overlay_stickers">
			<?php if($product['Product']['american_apparel']){?>
			<div class="american_apparel">
				<a href="<?php echo $rootDir ?>products/view/<?php echo $product['Product']['id'] ?>/<?php echo $product['ColorsProduct'][0]['color_id'] ?>">
					<img width="100" border="0" src="http://www.americanapparel.net/wholesaleresources/images/weuse2.gif"/>
				
			</div>
			<?php } ?>
			<div class="overlay_image">
				<a href="<?php echo $rootDir ?>products/view/<?php echo $product['Product']['id'] ?>/<?php echo $product['ColorsProduct'][0]['color_id'] ?>">
					<?php if(isset($product['Image'][0]['Upload']['name'])){?>
					<img width="200px" height="200px" src="https://carts.undergroundshirts.com/c/img/<?php echo $product['Image'][0]['Upload']['name']?>"/>
					<?php }else{?>
						<div style="width:200px;height:200px;border:none">&nbsp;</div>
					<?php }?>
				</a>
			</div>
		</div>
	</a>
	<a href="<?php echo $rootDir ?>products/view/<?php echo $product['Product']['id'] ?>/<?php echo $product['ColorsProduct'][0]['color_id'] ?>">
		<div class="overlay_swatch_wrapper">
			<?php if(!empty($product['ColorsProduct'][0]['Color'])){?>
			<div class='color_overlay_swatches_extra_boarder'>
				<div class='color_overlay_swatches'>	
					<?php foreach($product['ColorsProduct'] as $colorProduct){?>
						<a title="<?php echo $colorProduct['color'] ?>" href="<?php echo $rootDir ?>products/view/<?php echo $colorProduct['prod_id'] ?>/<?php echo $colorProduct['Color']['id'] ?>"><img src="http://catalog.undergroundshirts.com/swatches/<?php echo $colorProduct['Color']['filename'] ?>" width="10" alt="<?php echo $colorProduct['color'] ?>"></a>
					<?php }?>
				</div>
			</div>
			<?php }?>
		</div>
	</a>
	
</div>