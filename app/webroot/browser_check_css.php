<?php if(isset($browser)){
		if($browser->getBrowser() == Browser::BROWSER_IE) {
			if($browser->getVersion() == '7.0'){
				echo $html->css('common_IE_7');?>
				<link rel="stylesheet" href="<?php echo $secureRootDir?>unique/unique_IE_7.css" type="text/css" media="screen" title="no title" charset="utf-8"> 	
			<?php }else{//8.0
				echo $html->css('common_IE_8');?>
				<link rel="stylesheet" href="<?php echo $secureRootDir?>unique/unique_IE_8.css" type="text/css" media="screen" title="no title" charset="utf-8"> 
		<?php
			} 
		}
		else if($browser->getBrowser() == Browser::BROWSER_SAFARI) {
			echo $html->css('common_webkit');?>
			<link rel="stylesheet" href="<?php echo $secureRootDir?>unique/unique_webkit.css" type="text/css" media="screen" title="no title" charset="utf-8"> 
		<?php 
		}
		else if($browser->getBrowser() == Browser::BROWSER_CHROME) {
			echo $html->css('common_chrome');?>
			<link rel="stylesheet" href="<?php echo $secureRootDir?>unique/unique_chrome.css" type="text/css" media="screen" title="no title" charset="utf-8"> 
		<?php 
		}
	}
?>