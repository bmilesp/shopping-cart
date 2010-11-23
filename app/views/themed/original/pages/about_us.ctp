<style>
#bar
{
  background: #333;
	
  -moz-border-radius-bottomleft: 10px;
  -webkit-border-bottom-left-radius: 10px;

  -moz-border-radius-bottomright: 10px;
  -webkit-border-bottom-right-radius: 10px;

  -moz-border-radius-topleft: 10px;
  -webkit-border-top-left-radius: 10px;

  -moz-border-radius-topright: 10px;
  -webkit-border-top-right-radius: 10px;
  
  display: inline-block;

  color:#fff;
  
  font-weight: bold;
}

#bar img
{
	padding: 20px 10px 0;
}

</style>

<link href="css/lightbox.css" rel="stylesheet" type="text/css"/>

<script src="lightbox/prototype.js" type="text/javascript"></script>
<script src="lightbox/scriptaculous.js" type="text/javascript"></script>
<script src="lightbox/lightbox.js"></script>

<div id="faq_page">
<br><br>
Underground Printing was founded by college students (and childhood friends) Rishi Narayan and Ryan Gregg out of Rishi's dorm room in the spring of 2001. The company was founded as a custom screenprinting and embroidery apparel maker serving the campus and local community, and today UGP continues to specialize in custom printed garments with locations throughout the nation.
<br><br>
Our approach to apparel is a little different than the bookstores you're used to on campus. First, our apparel focuses on better fits, softer and high end materials, and hip, fun and original designs. We're constantly changing our product line up to keep new, fresh styles and designs available to keep pace with the beat on campus. We also offer a number of unique, one-of-a-kind products you can't find anywhere else! Contact us today to get a quote on custom printed or embroidered apparel or get answers to any questions you may have about our unique collegiate apparel!<Br><Br>

<table style="width: 100%;">
	<tr>
		<td>
			<div id="map"><?php echo $siteConfig->getCartDBField('google_map_code') ?></div>
		</td>
		<td style="font-weight: bold; font-size: x-large; color: #333; text-align: center;">
			<?php echo $siteConfig->getCartDBField('address'); ?>
			<Br><BR>
			<?php  echo urldecode($siteConfig->getCartDBField('times')); ?>
			<Br><BR>
			<?php echo $siteConfig->getCartDBField('phone'); ?>
			<Br>
			<?php echo $siteConfig->getCartDBField('fax'); ?>
			<Br>
			<?php $email = $siteConfig->getCartDBField('contact_email'); ?>
			<a href="mailto:<?php echo $email ?>"><?php echo $email; ?></a>
		</td>
	</tr>
</table>
<Br><Br>

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