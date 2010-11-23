<div class="cart-panel-item cart-panel-coupon">
	<div class="cart-item-image">
		<?php echo $html->image('coupon.png',array('width'=>50))?>
	</div>
	<div class="cart-item-description">
		<span class="cart-item-title">Coupon: </span><span class="cart-item-color"><?php echo urldecode($coupon['Coupon']['description']) ?></span>
	</div>
</div>
<div style="clear:both"></div>