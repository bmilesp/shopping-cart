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
	padding: 10px;
}

</style>

<link href="css/lightbox.css" rel="stylesheet" type="text/css"/>

<script src="lightbox/prototype.js" type="text/javascript"></script>
<script src="lightbox/scriptaculous.js" type="text/javascript"></script>
<script src="lightbox/lightbox.js"></script>

<div id="faq_page">
<center>
<BR/><BR/>
<img src="img/aboutus.jpg">
<br/><br/>
Sconnie Nation is dedicated to celebrating the Wisconsin lifestyle!
<BR/><BR/>
Sconnie Nation is based in Madison, WI and is completely student-owned and operated. All of our designs are in-house, unique, masterpieces that cannot be found anywhere else. The Sconnie tradition began way back in 1848 when Wisconsin became the 30th state in the Union and continues today. We started the company during the spring of 2004 in our freshmen dorm room out in Turner Kronshage with the goal of spreading Sconnie pride across the country.
<BR/><BR/>
The idea behind Sconnie Nation is simple. Anyone from Wisconsin, who attends school in Wisconsin, or just loves the dairy state in general can identify with Sconnie. Sconnie is anything of or relating to Wisconsin. Sconnie is an identity. It can be used as a noun ("I am a Sconnie") or an adjective ("Look at that Sconnie truck"). You don't have to be from Wisconsin to appreciate the Sconnie movement. It's all about embracing and celebrating this genuinely Wisconsinesque environment we call home. Sconnie is tailgating, bowling, bubblers, washing cheese curds down with a beer, having a tractor-shaped mailbox, or eating a cream puff. If you like eating a brat and cheering for the Pack, you know what we're talking about.
<BR/><BR/>
Check us out online or at our new store at 521 State Street!<Br><Br>

<table style="width: 100%; text-align: center;">
	<tr>
		<td>
			Ben Fiechtner<Br/>
			Co-Founder
		</td>
		<td>
			<img src="<?php echo $secureRootDir?>unique/img/troyandben.jpg">
		</td>
		<td>
			Troy Vosseller<BR/>
			Co-Founder
		</td>
	</tr>
</table>

<Br/><Br/>

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
				<a class="lightbox_s" href="<?php echo $secureRootDir?>unique/img/store/<?php echo $i ?>.jpg"><img alt="" src="<?php echo $secureRootDir?>unique/img/store/<?php echo $i ?>_thumb.jpg"></a>
			<?php } ?>
			
			<br><Br>
			CLICK ON AN IMAGE TO ZOOM IN
			<BR><Br>
		</div>
	</center>
<?php }?>
</div>