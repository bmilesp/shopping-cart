<?php  
$javascript -> link('jquery.lightbox-0.5.min.js', false); 	
$html -> css('jquery.lightbox-0.5', null, array(), false);

$jscode = <<<EOAJAVASCRIPT
$().ready(init);

function init(){
	$('.lightbox_s').lightBox();
}

EOAJAVASCRIPT;

echo $javascript->codeBlock($jscode, array('inline'=>false));

?>
<div style="padding:0 20px">
<?php echo $siteConfig->getCartDBField('about_us'); ?>
<?php
$num_pics = $siteConfig->getCartDBField('num_pics');

if ($num_pics > 0){ ?>
	<center>
		<div id="bar">
			<?php for ($i=1; $i <= $num_pics; $i++) {?>
				<a class="lightbox_s" href="<?php echo $secureRootDir?>unique/<?php echo $siteConfig->site ?>/img/store/<?php echo $i ?>.jpg"><img alt="" src="<?php echo $secureRootDir?>unique/<?php echo $siteConfig->site ?>/img/store/<?php echo $i ?>_thumb.jpg"></a>
			<?php } ?>
			
			<br><Br>
			CLICK ON AN IMAGE TO ZOOM IN
			<BR><Br>
		</div>
	</center>
<?php }?>
</div>