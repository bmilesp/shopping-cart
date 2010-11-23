<div id="twitter_book_icons">
	<?php $img =  $html->image("{$secureRootDir}img/twitter.png",array('alt'=>'Twitter'));
		echo $html->link($img, $html->url('http://twitter.com/lebronjones'),array('escape'=>false,'target'=>'_blank'));
	?>
	<?php $img =  $html->image("{$secureRootDir}img/facebook.png",array('alt'=>'Facebook'));
		echo $html->link($img, $html->url('http://www.facebook.com/staygonelebron'),array('escape'=>false,'target'=>'_blank'));
	?>
</div>