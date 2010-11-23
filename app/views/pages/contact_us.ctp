<div id="faq_page">
	<h1 class="contact-us-header">Contact Underground Printing</h1>
	<table>
		<tr>
			<td>
				<div id="map"><?php echo $siteConfig->getCartDBField('google_map_code') ?></div>
			</td>
			<td style="text-align: left; padding: 25px">
				<?php $email = $siteConfig->getCartDBField('contact_email'); ?>
				<a href="mailto:<?php echo $email ?>"><?php echo $email; ?></a>
				<Br><br>
				<?php echo $siteConfig->getCartDBField('phone'); ?>
				<Br><BR>
				<?php echo $siteConfig->getCartDBField('address'); ?>
				<Br><BR>
				<strong>Hours:</strong><br>
				<?php  echo urldecode($siteConfig->getCartDBField('times')); ?>
			</td>
		</tr>
	</table>
</div>