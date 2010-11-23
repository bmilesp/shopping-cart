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
header("Pragma: no-cache");
header("Cache: no-cache");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
	<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
	<META HTTP-EQUIV="Expires" CONTENT="0">	
	<title>
		<?php echo $siteConfig -> page_title . " - " . $title_for_layout; ?>
	</title>
	<link rel="icon" href="<?php echo $secureRootDir?>unique/<?php echo $siteConfig -> site?>/img/favicon.png"/>
	<link rel="shortcut icon" href="<?php echo $secureRootDir?>unique/<?php echo $siteConfig -> site?>/img/favicon.png"/>

	<?php echo $html->css('common'); ?>
	<?php echo $html->css('login_pages'); ?>
	<?php require_once("$baseFilePath/app/webroot/browser_check_css.php"); //leave this here to override common.css! ?>
	<?php echo $html->css('top_menu_nav');?>
	<?php echo $html->css('product_rollovers_display'); ?>
	<link rel="stylesheet" href="<?php echo $secureRootDir?>unique/<?php echo $siteConfig -> site?>/unique.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<?php echo $javascript -> link('jquery.1.4.js'); ?>
	<?php echo $javascript -> link('jquery-ui-1.8.1.custom.min.js'); ?>
	<?php echo $html -> css('top_menu_nav'); ?>
	<link rel="stylesheet" href="<?php echo $secureRootDir?>unique/<?php echo $siteConfig -> site?>/unique_colors.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<?php echo $scripts_for_layout;?>	
	
</head>
<body>
	<div id="frame">
			<?php require_once("$baseFilePath/app/webroot/unique/{$siteConfig -> site}/header.php") ?>
			<?php echo $this->element('nav/top_menu_nav',array('groups'=>$mainMenuGroups)) ?>
		<div class="cushion">
			<div id="content">
				<?php echo $this->Session->flash(); 
					  echo $this->Session->flash('auth');
				?>
				<?php echo $content_for_layout; ?>
			</div>
			<div style="clear:both"/>
		</div>
		<div id="footer">
			<?php include("$baseFilePath/app/webroot/unique/{$siteConfig -> site}/footer.php");?>
			<BR>
			<center>
				<span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=OxZziUmExlGiCvxwWHOmQfMceJrP1mb3uwk2b1qT0nm3toSM7Hy"></script><br/><a style="font-family: arial; font-size: 9px" href="http://www.godaddy.com/ssl/ssl-certificates.aspx" target="_blank">GoDaddy</a></span>
			</center>
			<div style="clear:both"></div>
		</div>
	</div>
<?php echo $siteConfig->getCartDBField('analytics_code'); ?>

<?php echo $siteConfig->getCartDBField('adRoll_code'); ?>

<?php echo $this->element('sql_dump'); ?>

</body>
<?php 	if($_SERVER['SERVER_ADDR'] == '69.130.6.6'){
			var_dump($_SESSION);
			var_dump($session);
		}
?>
</html>