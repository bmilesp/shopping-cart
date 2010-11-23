<div id="cartPanelWrapper">
	<div id="cartPanel" onclick="window.location = '<?php echo $secureRootDir ?>orders/cart'">
			<div id="cartPanelImageWrapper" class="cart_panel_image_out"></div>
			<div id="cartPanelText">
			Total Items: <strong><?php echo $cartTotals['qty']?></strong>
			&nbsp;&nbsp;&nbsp;
			Total Price: <strong>$<?php echo number_format($cartTotals['total'], 2)?></strong>
			</div>
	</div>
	<div id="cartPanelList">
		<div id="cartPanelListInner">
			<?php foreach ($cartItems as $cartItem){ 
				echo $this->element('cart_panel'. DS .'cart_panel_item',array( 'item'=>$cartItem,  
															 'cartItemImageUrl'=>$cartItemImageUrl));
			}?>
			<?php foreach ($coupons as $coupon){ 
				echo $this->element('cart_panel'. DS .'cart_panel_coupon',array('coupon'=>$coupon));
			}?>
		</div>
		<div id="cartPanelCheckoutButton">Checkout >></div>
	</div>
</div>
<script>
$().ready(init);

var numItems = <?php echo $cartTotals['qty'] ?>;

function init(){
	if(numItems > 0){
		$('#cartPanelWrapper').bind('mouseenter',myCartButtonMouseenter);
		$('#cartPanelWrapper').bind('mouseleave',myCartButtonMouseleave);
		$('#cartPanel').bind('mouseenter',myCartPanelMouseenter);
		$('#cartPanel').bind('mouseleave',myCartPanelMouseleave);
		$('#cartPanel').addClass('cart-panel-active');
		$('#cartPanelCheckoutButton').bind('click',navigateToCheckout);
	}
}

function myCartButtonMouseenter(){
	$('#cartPanelList').stop(true,true).show('slide',{direction:'up', easing:'easeInOutQuint'},500);
}

function myCartButtonMouseleave(){
	$('#cartPanelList').hide('slide',{direction:'up', easing:'easeInOutQuint'},500);
}

function myCartPanelMouseenter(){
	$('#cartPanel #cartPanelImageWrapper').addClass('cart_panel_image_over');
	$('#cartPanel #cartPanelImageWrapper').removeClass('cart_panel_image_out');
}

function myCartPanelMouseleave(){
	$('#cartPanel #cartPanelImageWrapper').removeClass('cart_panel_image_over');
	$('#cartPanel #cartPanelImageWrapper').addClass('cart_panel_image_out');
}

function navigateToCheckout(){
	window.location = '<?php echo $secureRootDir."users/pre_checkout"?>';
}

</script>