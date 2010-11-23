<div id="cart_bar">
	Your Cart
	<div id="quantifier">
		<?php echo $cartTotals['qty'] ?> item(s)
	</div>
</div>
<?php
if ($cartTotals['qty'] == 0  && $browser->getBrowser() == Browser::BROWSER_IE)
{
	echo "<table class='cart_item' style='background: #fff;'>";
	echo 	"<tr>";
	echo 		"<td>";
	echo 			"&nbsp;";
	echo 		"</td>";
	echo 		"<td style='color: #333 !important; text-align: center;'>";

	echo 			"<center>Where did my items go?!?!  <a href='/pages/faq#16'>Click here</a> to fix this issue.</center>";
	
	echo 		"</td>";
	echo 		"<td>";
	echo 			"&nbsp;";
	echo 		"</td>";
	echo 	"</tr>";
	echo "</table>";
}

 foreach ($cartItems as $item){
	echo $this->element('cart_item',array('item'=>$item));
 } ?>
<?php foreach($coupons as $coupon){
	echo $this->element('cart_coupon',array('coupon'=>$coupon));
}?>

<?php 
if ($cartTotals['noTaxNoShipping'] < 50 && $siteConfig->getCartDBField('freeship_over_50')){?>
	<table class='cart_item'>
		<tr>
			<td>
				<?php echo $html->image('freeshippingicon.png', array('width'=>'181', 'height'=>'63', 'alt'=>'Free Shipping Icon'))?>
			</td>
			<td style="vertical-align:middle">
				If you spend just $<?php echo number_format(50 - $cartTotals['total'], 2) ?> more, you'll get free USPS or UPS Ground shipping!
			</td>
			<td>&nbsp;
			</td>	
		</tr>
	</table>
<?php } ?>
<Br><br>

<div id="total_block">
	<input type='button' class='remove_btn' style='float: left;' value='Clear Cart' onclick='window.location = "<?php echo $this->Html->url(array('controller'=>'orders', 'action'=>'cart_clear'),true,true) ?>";'>
	
	<?php echo $this->Form->create('CouponCode',array('url' => $this->Html->url(array('controller'=>'users','action'=>'pre_checkout'),true,true), 'id'=>'coupon_code' ));?>
		<span class="coupon_code_label">Coupon Code:</span><Br>
		<input type='text' name='code'>
		<input class="coupon_code_button" type="submit" value="add..." />
	<?php echo $this->Form->end()?>
	<?php echo $this->Form->create('CouponCode',array('url' => $this->Html->url(array('controller'=>'users','action'=>'pre_checkout'),true,true), 'id'=>'cart_frm' ));?>
	<?php echo $this->Form->end()?>
	<br>
	<span class='price'>$<?php echo number_format($cartTotals['total'], 2); ?></span>
	<br><br>
	<input type='button' value='<< Continue Shopping' onclick='window.location="<?php echo $this->Html->url("/",true) ?>";'>
	<input type='button' value='Checkout >>' onclick='document.getElementById("cart_frm").submit();'>
	<br><br>
</div>