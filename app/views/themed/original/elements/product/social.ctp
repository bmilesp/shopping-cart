<?php echo $this->Html->css('http://static.ak.fbcdn.net/connect.php/css/share-button-css');?>
<?php echo $this->Html->css('http://widgets.digg.com/css/buttons.css');?>
<?php $javascript->link('http://digg.com/tools/diggthis.js',false)?>
<?php $encodedUrl = urlencode("http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}") ?>
<div id="social">
	<a class="DiggThisButton">('<img src="http://digg.com/img/diggThisCompact.png" height="18" width="120" alt="DiggThis" />’)</a>
	
	<script type="text/javascript">
	tweetmeme_style = 'compact';
	</script>
	<?php echo $javascript->link('http://tweetmeme.com/i/scripts/button.js')?>
	<a name="fb_share" type="button" href="http://www.facebook.com/sharer.php">Share</a>
	<?php echo $javascript->link('http://static.ak.fbcdn.net/connect.php/js/FB.Share')?>
</script>