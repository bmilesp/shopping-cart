<?php
/* SVN FILE: $Id$ */
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
	<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
	<META HTTP-EQUIV="Expires" CONTENT="0">
	<?php
	if ($siteConfig->site_id == 24)
	{
		echo '<meta name="google-site-verification" content="wcjyK0Tc_XlA-f6UyFj3o73JPuXCHLR2lDOuw6amEwY" />';
	}
	?>
	<title>
		<?php echo $siteConfig -> page_title . " - " . $title_for_layout; ?>
	</title>
	<link rel="icon" href="<?php echo $secureRootDir?>unique/<?php echo $siteConfig -> site?>/img/favicon.png"/>
	<link rel="shortcut icon" href="<?php echo $secureRootDir?>unique/<?php echo $siteConfig -> site?>/img/favicon.png"/>
	<?php echo $html->css('carts'); ?>
	<?php echo $html->css('login_pages'); ?>
	<?php echo $html->css('common'); ?>
	<?php echo $html->css('global_styles'); ?>
	<?php echo $html->css('unique/unique'); ?>
	<?php echo $html->css('top_menu_nav'); ?>
	<?php echo $html->css('product_rollovers_display'); ?>
	<?php 
	if($browser->getBrowser() == Browser::BROWSER_IE) 
	{
		echo $html->css('common_IE');
	}
	else if($browser->getBrowser() == Browser::BROWSER_SAFARI) 
	{
		echo $html->css('common_webkit');
	}
	else if($browser->getBrowser() == Browser::BROWSER_CHROME) 
	{
		echo $html->css('common_chrome');
	}
	else
	{
		echo $html->css('common');
	}?>
	<?php echo $javascript -> link('jquery.1.4.js'); ?>
	<?php echo $scripts_for_layout;?>
	<?php echo $html->css('global_overrides'); ?>
	<link rel="stylesheet" href="<?php echo $secureRootDir?>unique/<?php echo $siteConfig -> site?>/unique_colors.css" type="text/css" media="screen" title="no title" charset="utf-8">
</head>
<body>
	<div id="frame">
		<?php echo $this->element('newsletter')?>
		<?php 
		$authUser = (isset($authUser)? $authUser : array());
		echo $this->element('login_search_panel',array('user'=>$authUser));
		//for etag:
		$prefix = (isset($prefix))? "_".$prefix : null;
		?>
		<?php require_once("$baseFilePath/app/webroot/unique/{$siteConfig -> site}/header_original.php") ?>
		<div id="content">
			<div class="cushion">
				<div id="sub_header">
				<?php echo $this->Session->flash(); 
					  echo $this->Session->flash('auth');
				?>
				<?php 	$selectedTagId = (isset($selectedTagId))? $selectedTagId : array();
						echo $this->element('menu_selector', array('groups'=> $mainMenuGroups, 'selectedTagId'=>$selectedTagId));?>
				</div>
				<div style="clear:both"></div>
				<div id="content_wrapper">		
						<?php echo $content_for_layout; ?>
				</div>
			</div>
		</div>
		<div id="footer">
			<div id="copyright">
				<?php include("$baseFilePath/app/webroot/unique/{$siteConfig -> site}/footer_original.php");?>
				<?php  echo $html->image('visa_icon.gif', array('alt' => 'Visa', 'width' =>39, 'height'=>26))?>
				<?php  echo $html->image('mastercard_icon.gif', array('alt' => 'Master Card', 'width' =>39, 'height'=>26))?>
				<?php  echo $html->image('discover_icon.gif', array('alt' => 'Discover', 'width' =>39, 'height'=>26))?>
				<?php  echo $html->image('amex_icon.gif', array('alt' => 'American Express', 'width' =>39, 'height'=>26))?>
				<br>
				&copy;<?php echo date('Y')?> <?php echo $siteConfig->getCartDBField('copyright_name');?>
				<br>
				<?php echo $siteConfig->getCartDBField('copyright_line2');?> 
			</div>
		</div>
	</div>
	<center>
<table id="sitesealTable">
	<tr>
		<td>
<span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=12ZrvW7D6oPu1wVoyHWK94nzHmT8jHiXOZUiPBNJvoHgXiPs5K78"></script><br/><a style="font-family:arial;font-size:9px" href="http://help.godaddy.com" target="_blank">GoDaddy</a></span>
&nbsp;&nbsp;
		</td>
		<td>
<script id="siteSeal" type="text/javascript" src="//tracedseals.starfieldtech.com/siteseal/get?scriptId=siteSeal&amp;sed=71e3304ef7ff4563886d8f280461a862d377c5ac8bac2970436d0ca98e4e4fa7">
</script>
		</td>
	</tr>
</table>
</center>


<?php echo $siteConfig->getCartDBField('analytics_code'); ?>

<?php echo $siteConfig->getCartDBField('adRoll_code'); ?>

<?php echo $this->element('sql_dump'); ?>

</body>
</html>