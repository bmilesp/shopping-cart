<?php  $javascript->link('jquery.corners.js',false);
$jscode = <<<EOAJAVASCRIPT

$().ready(init);

function init(){
	$.fn.corner.defaults.useNative = false;
	$('.alternate_image').corner('21px');
	$('.alternate_image_wrapper').bind('click',changeSpotlightImage);
}


function changeSpotlightImage(e){
	$('#main_images').children().addClass('main_image_hidden');
	$('#main_images').find('#'+$(this).attr('id')).removeClass('main_image_hidden');
}

EOAJAVASCRIPT;

$javascript->codeBlock($jscode, array('inline'=>false));
?>
<div>
	<div id="main_image_wrapper">
		<div id="main_images" style="background-image:url('<?php echo $cartsAdminUrl?>c/img/<?php echo $images['Background']['Upload']['name']?>'); background-repeat:repeat-x; background-position:bottom">
			<?php foreach($product['pics'] as $key=>$position){?>
				<div id="<?php echo $key?>" class="main_image <?php echo ($key =='pic1')? null : 'main_image_hidden' ?>" style="background-repeat:no-repeat; background-position:center top; background-image:url('<?php echo $prodImgUrl."/position_{$position}/{$product['Product']['id']}_{$product['ColorsProduct']['color_id']}.jpg"?>')"></div>
			<?php }?>
		</div>
		<div id="main_image_social_media_links">
			<table>
				<tr>
					<td><?php						
						$image = $html->image('facebook.png');
					    //$image is passed as the first argument instead of link text
					    echo $html->link($image, 
					    				 "http://www.facebook.com/sharer.php?u=".urlencode($socialURL)."&src=sp",
					            		 array('target'=>'_blank','escape'=>false)
					            );
						?>
					</td>
					<td>
						<?php						
						$image = $html->image('digg.png');
					    //$image is passed as the first argument instead of link text
					    echo $html->link($image, 
					    				 "http://digg.com/submit?phase=2&url=".urlencode($socialURL)."&title=".urlencode($pageTitle),
					            		 array('target'=>'_blank','escape'=>false)
					            );
						?>
					</td>
					<td>
						<?php						
						$twitterImage = $html->image('twitter.png');
					    //$image is passed as the first argument instead of link text
					    echo $html->link($twitterImage, 
					    				 "http://twitter.com/home?status=".urlencode('Currently Viewing '.$pageTitle.' - '.$bitlyURL),
					            		 array('target'=>'_blank','escape'=>false)
					            );
						?>
						</td>
					<td>
						<?php						
						$image = $html->image('stumble.png');
					    //$image is passed as the first argument instead of link text
					    echo $html->link($image, 
					    				 "http://www.stumbleupon.com/submit?url=".urlencode($socialURL)."&title=".urlencode($pageTitle),
					            		 array('target'=>'_blank','escape'=>false)
					            );
						?>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div id="alternate_images">
		<?php 
			foreach($product['pics'] as $key=>$position){?>
				<div class="alternate_image_wrapper" id="<?php echo $key?>">
					<div class="alternate_image" style="background-image:url('<?php echo $cartsAdminUrl?>c/img/<?php echo $images['Background']['Upload']['name']?>'); background-repeat:repeat-x; background-position:top">
						<?php 
							echo $html->image($prodImgUrl."/position_{$position}/{$product['Product']['id']}_{$product['ColorsProduct']['color_id']}.jpg",
											  array('width'=>'80px', 'height'=>'80px','class'=>'alternate_image_img'));
						?>
					</div>
					<div class="alternate_image_hover_border"></div>
				</div>
		<?php } ?>
	</div>
</div>