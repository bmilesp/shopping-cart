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
	<title>
		<?php echo $siteConfig -> page_title . " - " . $title_for_layout; ?>
	</title>
	<link rel="icon" href="<?php echo $secureRootDir?>unique/img/favicon.png"/>
	<link rel="shortcut icon" href="<?php echo $secureRootDir?>unique/img/favicon.png"/>

	<?php echo $html->css('common'); ?>
	<?php echo $html->css('login_pages'); ?>
	<?php require_once("$baseFilePath/app/webroot/browser_check_css.php"); //leave this here to override common.css! ?>
	<?php //echo $html->css('top_menu_nav');?>
	<?php echo $html->css('product_rollovers_display'); ?>
	<link rel="stylesheet" href="<?php echo $secureRootDir?>unique/<?php echo $siteConfig -> site?>/unique.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<?php echo $javascript -> link('jquery.1.4.js'); ?>
	<?php echo $javascript -> link('jquery-ui-1.8.1.custom.min.js'); ?>
	<?php echo $javascript -> link('jquery.hoverintent.js'); ?>
	<?php echo $javascript -> link('jquery.superfish.js'); ?>
	<?php echo $html -> css('top_menu_nav'); ?>
	<link rel="stylesheet" href="<?php echo $secureRootDir?>unique/<?php echo $siteConfig -> site?>/unique_colors.css" type="text/css" media="screen" title="no title" charset="utf-8">
	
	<?php echo $scripts_for_layout;?>
	
	<script>
	$().ready(init);
	function init(){
		$("ul.sf-menu").superfish({delay: 0, autoArrows: false, speed: 1});
	}
 
	</script>
	
</head>
<body>
	<div id="frame">
			<?php require_once("$baseFilePath/app/webroot/unique/{$siteConfig -> site}/header.php") ?>
			<?php echo $this->element('nav/top_menu_nav',array('groups'=>$mainMenuGroups)) ?>
		<div class="cushion">
			<div id="side-bar-nav" class="pane">
				<?php echo $this->element('nav/side_bar_nav',array('groups'=>$sidebarGroups,
																   'relatedTags'=> (isset($relatedTags))? $relatedTags : array(),
																   'selectedTags'=>(isset($verifiedTags))? $verifiedTags : array(),
																   'selectedGroup'=>(isset($selectedGroup))? $selectedGroup : null)) ?>
			</div>
			<div id="content-with-nav">
				<div id="bread-crumb-wrapper">
					<?php echo $this->element('bread_crumb',array('list'=>(isset($verifiedTags))? $verifiedTags : array()))?>
				</div>
				<?php echo $this->Session->flash(); 
					  echo $this->Session->flash('auth');
				?>
				<?php echo $content_for_layout; ?>
			</div>
			<div style="clear:both"/>
		</div>
		<div id="footer">
			<?php include("$baseFilePath/app/webroot/unique/{$siteConfig -> site}/footer.php");?>
			<div style="clear:both"></div>
		</div>
	</div>
	<!-- 
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
-->

<!--******Google Analytics******-->
<script type="text/javascript">
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
	var pageTracker = _gat._getTracker("UA-11683368-1");
	pageTracker._trackPageview();
} catch(err) {}
</script>
<!--****************************-->
<?php echo $this->element('sql_dump'); ?>
			
</body>
</html>