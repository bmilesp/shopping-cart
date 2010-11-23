<?php  
$imageSize = 200;
$firstImageSize = (count($product['pics']) < 3) ? 300 : $imageSize;
?>
<div id='prod_table' style="width:<?php echo (count($product['pics']) == 1)? $firstImageSize : 265 + $firstImageSize ?>px">
	<?php 
		
		foreach($product['pics'] as $key=>$position){?>	
			<div class="productViewImage">
				<?php $size = ($position == 1)? $firstImageSize : $imageSize;
				echo $html->image($prodImgUrl."/position_{$position}/{$product['Product']['id']}_{$product['ColorsProduct']['color_id']}.jpg",
							  array('width'=>"{$size}px", 'height'=>"{$size}px",'class'=>'prod_img','style'=>"width:{$imageSize};height:{$imageSize}"));?>
			</div>
		 <?php } 
	?>
</div>
<div style="clear:both; padding: 10px;"></div>
<div>
	<center>
	<div id='swatches'>
		<?php foreach ($colors as $color){
			if($colorId == $color['ColorsProduct']['color_id']){
				echo $form->input('color_id',array('type'=>'hidden', 'value'=>$color['ColorsProduct']['color_id']));
			}?>
			<?php $style = ($colorId == $color['ColorsProduct']['color_id'])? 'style="border: 3px solid #fff;"': null?>
			<?php 
				$iconSize = ($colorId == $color['ColorsProduct']['color_id'])? '24px' : '16px';
				$image =  $html->image("http://catalog.undergroundshirts.com/swatches/{$color['Color']['filename']}",
								  array('alt'=>$color['Color']['color'],
								  		'width'=>$iconSize, 'height'=>$iconSize)
								 );
				echo $html->link($image,array('action'=>'view',$productId,$color['ColorsProduct']['color_id']),
										array('title'=>$color['Color']['color'],
											  'escape'=>false, 'style'=>$style)
								 );
				?>

		<?php }?>
	</div>
	</center>
</div>