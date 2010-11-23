<?php 

//set up code object as $couponCodes for coupon conditionals:
// if coupon type is shipping, gather shipping  


foreach($coupons as $key=>$coupon){
	if($coupon['Coupon']['discountto']=='shipping'){
		if($ship_type == 'UPS 2nd Day Air'){
			if(!in_array('ups_2_day_air',$coupon['Coupon']['shippingDiscounts'])){
				unset($coupons[$key]);
			}
		}else if ($ship_type == 'UPS Next Day Air'){
			if(!in_array('ups_next_day_air',$coupon['Coupon']['shippingDiscounts'])){
				unset($coupons[$key]);
			}
		}
	}
}

?>
<style>
#rec
{
  width: 100%;
  margin-left: auto;
  margin-right: auto;
  text-align: center;
}

#rec td
{
  text-align: center;
}

#rec_userinfo
{
  width: 250px;
}

#rec_payment
{
  font-size: small;
  width: 250px;
}

#rec_credit
{
  font-size: small;
  text-align: center;
  margin-left: auto;
  margin-right: auto;
}

*.left_td
{
  text-align: left ! important;
}

*.right_td
{
  text-align: right ! important;
}

*.bordered
{
  border: 1px solid #333;
}

#listing
{
  width: 500px;
  text-align: center;
  margin-left: auto;
  margin-right: auto;
}

#warning
{
  width: 400px;
  color: red;
  margin-left: auto;
  margin-right: auto;
}

#listing th
{
  background: #333;
  color: #fff;
}

#rec table
{
  margin: auto;
}
</style>
	<Br><br>
<div id="rec">

		<strong>PAYMENT CONFIRMATION</strong><br><br>
		<table>
			<tr>
				<td>
					<strong>Thank you for your order <?php echo $cfname; ?>!</strong>
					<br><Br>
					If you would like to check the status of your order, manage addresses, update your email, or customize many other options, please visit your personal <a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'view',$user['User']['id']),true,true)?>">account page</a>.
					<BR><BR>
					Thank you for shopping with us.
				</td>
			</tr>
			<tr>
				<td class="bordered">
					<?php
					foreach ($cartItems as $item)
					{
						echo $this->element('cart_item',array('item'=>$item, 'modifiable'=>false));
					}
					
					if ($gift_wrap)
					{
						echo $this->element('cart_gift_wrap',array('giftPrice'=>$totalVals['giftWrapTotal']));
					}
					
					
					foreach( $coupons as $coupon)
					{
						echo $this->element('cart_coupon',array('coupon'=>$coupon));
					}
					
					?>
					<br><br>
					<div id="total">

						<strong>Sub-Total:</strong> $<?php echo number_format($totalVals['noTaxNoShipping'], 2); ?>
						<Br>
						<strong>Shipping & Handling:</strong> $<?php echo number_format($totalVals['shippingPrice'], 2); ?>
						<Br>
						<?php if (isset($totalVals['discount']) && $totalVals['discount'] > 0){ ?>
							<strong>Discount Amount:</strong> -$<?php echo number_format($totalVals['discount'], 2); ?>
							<Br>
						<?php }?>
						<strong>Tax:</strong> $<?php echo number_format($totalVals['totalTax'], 2); ?>
						<Br>
						<strong>Total:</strong> $<?php echo number_format($totalVals['total'], 2); ?>
						<br><br>
						<strong>Shipping Type:</strong> <?php echo $ship_type?>
						<br>
						<strong>In-hands Date:</strong>  <?php echo $inHandsDate ?>
						<br><br>
						<strong>Shipping Address:</strong>
						<br>
						<?php echo $shippingAddress['firstname']?> <?php echo $shippingAddress['lastname']?>
						<br>
						<?php echo $shippingAddress['address_1']?>
						<?php if($shippingAddress['address_2']){
								$shippingAddress['address_2'] = "<br>".$shippingAddress['address_2'];
						}?>
						<?php echo $shippingAddress['address_2']?>
						<br>
						<?php echo $shippingAddress['city']?>, <?php echo $shippingAddress['state']?> <?php echo $shippingAddress['zip']?>
						
					</div>
					<Br><bR>
				<td>
			</tr>
			<tr>
				<td id="rec_credit_td" class="bordered">
					<strong>CREDIT / DEBIT CARD INFORMATION</strong>
					<Br><br>
					<table id="rec_credit">
						<tr>
							<td class="right_td">
								<strong>Customer:</strong>
							</td>
							<td class="left_td">	
								<?php echo $cfname . " " . $clname;?>
							</td>
						</tr>
						<tr>
							<td class="right_td">
								<strong>Transaction ID:</strong>
							</td>
							<td class="left_td">	
								<?php echo $trans_id; ?>
							</td>
						</tr>
						<tr>
							<td class="right_td">
								<strong>Amount Charged:</strong>
							</td>
							<td class="left_td">	
								<?php echo "$" . number_format($total, 2); ?>
							</td>
						</tr>
						<tr>
							<td class="right_td">
								<strong>Card Type:</strong>
							</td>
							<td class="left_td">	
								<?php echo $creditCardType;?>
							</td>
						</tr>
						<tr>
							<td class="right_td">
								<strong>Card Number:</strong>
							</td>
							<td class="left_td">
								<?php
								$str = 	$creditCardNumber;
								$tmp = "";
								for ($i=0; $i < strlen($str); $i++)
								{
									$tmp .= "X";
								}
								
								$cardNum = $tmp . substr($str, -4);
								echo $cardNum;
								?>
							</td>
						</tr>
					</table>
				</td>
			</tr>	
		</table>
		
		<BR><BR>
			
		<?php echo urldecode($siteConfig->getCartDBField('receipt_tail')); ?>
		
		<?php
		if (isset($cemail))
		{
			$to = urldecode($cemail);
		}
		else
		{
			$to = "receipts@undergroundshirts.com";
		}
		$body = "<html><body>
			<style>
			#rec
			{
			  width: 100%;
			  margin-left: auto;
			  margin-right: auto;
			  text-align: center;
			}

			#rec td
			{
			  text-align: center;
			}

			#rec_userinfo
			{
			  width: 250px;
			}

			#rec_payment
			{
			  font-size: small;
			  width: 250px;
			}

			#rec_credit
			{
			  font-size: small;
			  text-align: center;
			  margin-left: auto;
			  margin-right: auto;
			}

			*.left_td
			{
			  text-align: left ! important;
			}

			*.right_td
			{
			  text-align: right ! important;
			}

			*.bordered
			{
			  border: 1px solid #333;
			}

			#listing
			{
			  width: 500px;
			  text-align: center;
			  margin-left: auto;
			  margin-right: auto;
			}

			#warning
			{
			  width: 400px;
			  color: red;
			  margin-left: auto;
			  margin-right: auto;
			}

			#listing th
			{
			  background: #333;
			  color: #fff;
			}

			#rec table
			{
			  margin: auto;
			}
			body, td, input, textarea, select {
				font-size: 16px;
			}
			</style>
		<link rel='stylesheet' href='css/email.css' type='text/css' media='screen' title='no title' charset='utf-8'>
		<strong>PAYMENT CONFIRMATION</strong><br><br>
		<table id='wrapper'>
			<tr>
				<td>
					Thank you for your payment.<br><Br>
				</td>
			</tr>
			<tr>
			<td class='bordered'>";
			
				foreach ($cartItems as $item)
					{
						$body .= $this->element('cart_item',array('item'=>$item, 'modifiable'=>false));
					}
					
					if ($gift_wrap)
					{
						$body .= $this->element('cart_gift_wrap',array('giftPrice'=>$totalVals['giftWrapTotal']));
					}
					
					
					foreach( $coupons as $coupon)
					{
						$body .= $this->element('cart_coupon',array('coupon'=>$coupon));
					}
					
				$discount = null;
				if (isset($totalVals['discount']) && $totalVals['discount'] > 0){ 
							$discount = "Discount Amount: -$".number_format($totalVals['discount'], 2)." 
							<Br>";
				}
					
				$body .= "<br><br>
					<div id='total'>

						<strong>Sub-Total:</strong> $". number_format($totalVals['noTaxNoShipping'], 2)."
						<Br>
						$discount
						<strong>Shipping & Handling:</strong> $". number_format($totalVals['shippingPrice'], 2)."
						<Br>
						<strong>Tax:</strong> $". number_format($totalVals['totalTax'], 2)."
						<Br>
						<strong>Total:</strong> $". number_format($totalVals['total'], 2)."
						<br><br>
						<strong>Shipping Type:</strong> $ship_type
						<br>
						<strong>In-hands Date:</strong> $inHandsDate
						<br>
						<strong>Shipping Address:</strong>
						<br>
						{$shippingAddress['firstname']} {$shippingAddress['lastname']}
						<br>
						{$shippingAddress['address_1']}
						{$shippingAddress['address_2']}
						<br>
						{$shippingAddress['city']}, {$shippingAddress['state']} {$shippingAddress['zip']}
					</div>
					<Br><bR>
			<td>
			</tr>
			<tr>
				<td id='rec_credit_td' class='bordered'>
					<strong>CREDIT / DEBIT CARD INFORMATION</strong>
					<Br><br>
					<table id='rec_credit'>
						<tr>
							<td class='right_td'>
								<strong>Customer:</strong>
							</td>
							<td class='left_td'>	
								$cfname $clname
							</td>
						</tr>
						<tr>
							<td class='right_td'>
								<strong>Transaction ID:</strong>
							</td>
							<td class='left_td'>	
								$trans_id
							</td>
						</tr>
						<tr>
							<td class='right_td'>
								<strong>Amount Charged:</strong>
							</td>
							<td class='left_td'>";	
							$body .= "$" . number_format($totalVals['total'], 2);
						$body .="</td>
						</tr>
						<tr>
							<td class='right_td'>
								<strong>Card Type:</strong>
							</td>
							<td class='left_td'>	
								$creditCardType
							</td>
						</tr>
						<tr>
							<td class='right_td'>
								<strong>Card Number:</strong>
							</td>
							<td class='left_td'>
								$cardNum
							</td>
						</tr>
					</table>
				</td>
			</tr>	
		</table>
		<br><br>
		If you have any questions or concerns feel free to contact us at 
		<a href='mailto:".$siteConfig->getCartDBField('customer_contact_email')."'>".$siteConfig->getCartDBField('customer_contact_email')."</a>.
		<BR><BR>
		" . urldecode($siteConfig->getCartDBField('receipt_tail_email')) . "
		</body></html>";
		$from = $siteConfig->getCartDBField('customers_email_receipt_from_address');
		$headers  = "From: $from\r\n";
		$headers .= "Content-type: text/html\r\n";
		$headers .= "BCC: receipts@undergroundshirts.com\r\n";
		mail($to, $siteConfig->getCartDBField('site_name')." - Receipt", $body, $headers);


// Unset all of the session variables in the cart.
$_SESSION['cart'] = array();
//$_SESSION['Selected'] = array();
$_SESSION['Transport'] = array();

?>

</div>

<?php echo $siteConfig->getCartDBField('conversion_code'); ?>