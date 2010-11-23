	
<div id="prepay">
<?php echo $this->Form->create(null,array('url' => $this->Html->url(array('controller'=>'orders','action'=>'payment'),true,true), 
															'id'=>'cart_frm'));?>
	<input type='hidden' name='cart_size' value='<?php echo count($cartItems)?>'>
	<input type='hidden' name='tax_rate' value='<?php echo (is_numeric($taxRate))? $taxRate/100 : 0 ?>'>
<?php	
	$i=0;
	foreach($cartItems as $cartItem)
	{ ?>
		<input type='hidden' name='id<?php echo $i?>' value='<?php echo $cartItem['id'] ?>'>
		<input type='hidden' name='name<?php echo $i ?>' value='<?php echo $cartItem['name']?>'>
		<input type='hidden' name='price<?php echo $i ?>' value='<?php echo $cartItem['price'] ?>'>
		<input type='hidden' name='qty<?php echo $i ?>' value='<?php echo $cartItem['qty'] ?>'>
		<input type='hidden' name='status<?php echo $i ?>' value='0'>
		<input type='hidden' name='size<?php echo $i ?>' value='<?php echo $cartItem['size'] ?>'>
		<input type='hidden' name='weight<?php echo $i ?>' value='<?php echo $cartItem['weight'] ?>'>
		<input type='hidden' name='usps_price<?php echo $i ?>' value='<?php echo $cartItem['usps_price'] ?>'>
		<input type='hidden' name='is_apparel<?php echo $i ?>' value='<?php echo $cartItem['is_apparel'] ?>'>
		<input type='hidden' name='color_id<?php echo $i ?>' value='<?php echo $cartItem['color_id'] ?>'>
		<input type='hidden' name='U_id<?php echo $i ?>' value='<?php echo $cartItem['thisItemStatus']['U'] ?>'>
		<input type='hidden' name='B_id<?php echo $i ?>' value='<?php echo $cartItem['thisItemStatus']['B'] ?>'>
		<input type='hidden' name='AB_id<?php echo $i ?>' value='<?php echo $cartItem['thisItemStatus']['AB'] ?>'>
		<input type='hidden' name='O_id<?php echo $i ?>' value='<?php echo $cartItem['thisItemStatus']['O'] ?>'>
<?php $i++;} ?>

<center>	
<table id="order_bar">
</table>

<Br><br>

PLEASE ENTER YOUR CREDIT CARD INFORMATION
<Br>
<span id="ast">*</span><span id="ast_warning"> denotes mandatory fields.</span>
<br>
<span id="ast_warning">Note: We do not store your Credit Card information. 
			Credit Card Information is necessary for verification even though your total may be $0.00. </span>
<Br><Br>
<table>
	<tr>
		<td style='vertical-align: top;'>
			<table id="prepay_table">
				<tr>
					<th colspan=2 style="text-align: center;">
						Billing Information
					</th>
				</tr>
				<tr>
					<td>
						<Br><span id="ast">*</span>Payment Type:
					</td>
					<td>
						<Br>
						<?php 
							$cc_choice = null;
							if (isset($_SESSION['cart']['choice'])){
								$cc_choice = $_SESSION['cart']['choice'];
							
							}?>
						<select name="ctype" id="ctype_dropdown" onchange="ctype_decide();">
							<option value="Visa" <?php if($cc_choice=="Visa") {echo 'selected';} ?>>Visa</option>
							<option value="MasterCard" <?php if($cc_choice=="MasterCard") {echo 'selected';} ?>>Mastercard</option>
							<option value="Discover"<?php if($cc_choice=="Discover") {echo 'selected';} ?>>Discover</option>
							<option value="Amex" <?php if($cc_choice=="Amex") {echo 'selected';} ?>>American Express</option>
						</select><Br>
						<img src="<?php echo $secureRootDir?>/img/ccards.jpg" width="162" height="23" alt="Ccards">
					</td>
				</tr>
				<tr>
					<td>
						<span id="ast">*</span>Card Number:
					</td>
					<td>
						<span id="cnum">
							<?php
							if(isset($_SESSION['cart']['choice'])){
								if($_SESSION['cart']['choice']=="Amex") 
								{
									echo "<input type='text' name='cnumber1' id='cnumber1' size='4' maxlength='4' value='" . $_SESSION['cart']['cc1'] . "'> - <input type='text' name='cnumber2' id='cnumber2' size='6' maxlength='6' value='" . $_SESSION['cart']['cc2'] . "'> - <input type='text' name='cnumber3' id='cnumber3' size='5' maxlength='5' value='" . $_SESSION['cart']['cc3'] . "'><input type='hidden' name='cnumber4' id='cnumber4' value=''>";
								}
								else
								{
									echo '<input type="text" name="cnumber1" id="cnumber1" size="4" maxlength="4" value="' . $_SESSION['cart']['cc1'] . '"> - <input type="text" name="cnumber2" id="cnumber2" size="4" maxlength="4" value="' . $_SESSION['cart']['cc2'] . '"> - <input type="text" id="cnumber3" name="cnumber3" size="4" maxlength="4" value="' . $_SESSION['cart']['cc3'] . '"> -  <input type="text" id="cnumber4" name="cnumber4" size="4" maxlength="4" value="' . $_SESSION['cart']['cc4'] . '">';
								}
							}else{
								echo '<input type="text" name="cnumber1" id="cnumber1" size="4" maxlength="4" value=""> - <input type="text" name="cnumber2" id="cnumber2" size="4" maxlength="4" value=""> - <input type="text" id="cnumber3" name="cnumber3" size="4" maxlength="4" value=""> -  <input type="text" id="cnumber4" name="cnumber4" size="4" maxlength="4" value="">';
							}
							?>
						</span>
					</td>
				</tr>
				<tr>
					<td>
						<span id="ast">*</span>CVC:
					</td>
					<td>
						<input type="text" name="cvv2" id="cvv2" size="<?php if(isset($_SESSION['cart']['choice'])){
																				if($_SESSION['cart']['choice']=="Amex") {echo '4';}else{echo '3';}
																			 }
																		?>" <?php if(isset($_SESSION['cart']['cvc'])) {echo 'value="' . $_SESSION['cart']['cvc'] . '"';} ?>> <span id="link" onclick="window.open('http://www.undergroundshirts.com/cvc.php','cvc','width=500,height=500,toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,copyhistory=0,resizable=1')">What's This?</span>
					</td>
				</tr>
				<tr>
					<td>
						<span id="ast">*</span>Expiration:
					</td>
					<td>
						<input type="text" name="expmonth" id="expmonth" size="2"<?php if(isset($_SESSION['cart']['exp1'])) {echo 'value="' . $_SESSION['cart']['exp1'] . '"';} ?>> / <input type="text" name="expyear" id="expyear" size="4"<?php if(isset($_SESSION['cart']['exp2'])) {echo 'value="' . $_SESSION['cart']['exp2'] . '"';} ?>> <I>mm/yyyy</I><Br>
					</td>
				</tr>
				<tr>
					<td>
						<span id="ast">*</span>E-mail:
					</td>
					<td>
						<input type="text" name="cemail" id="cemail" value="<?php echo isset($_SESSION['User']['email'])? $_SESSION['User']['email'] : null  ?>">
						<Br>
					</td>
				</tr>
				<tr>
					<td>
						Phone:
					</td>
					<td>
						<input type="text" name="cphone" id="cphone" value="<?php echo isset($_SESSION['User']['phone'])? $_SESSION['User']['phone'] : null ; ?>"> <Br><I>555-555-1234</I>
					</td>
				</tr>
				<tr>
					
					<td colspan='2'>
					  <div style="padding-left:30px">
						<h3 class="billingHeader">Bill To:</h3>
						<?php echo $this->element('address_label', 
								array("data" => $billingAddress['BillingAddress'],
									  "editMode" => false,
									  "primaryKey" => 'bill_id',
									  "changeLink" => ($_SESSION['User']['cart_guest'] == 1)? 'guest_add' :'pre_checkout_billing',
									  "changeController" => ($_SESSION['User']['cart_guest'] == 1)? 'billing_addresses'	: null							
								));
						?>
						<input type="hidden" name="bill_id" id="bill_id" value="<?php echo $billingAddress['BillingAddress']['bill_id'] ?>"/>
			
					  </div>
					</td>
				</tr>
			</table>
		</td>
		<td style='vertical-align: top;'>
			<table id="prepay_table">
				<tr>
					<th colspan=2 style="text-align: center;">
						Shipping Information
					</th>
				</tr>
				<tr>
					
					<td>
						<h3 class="shippingHeader">Ship To:</h3>
						<?php echo $this->element('address_label', 
								array("data" => $shippingAddress['ShippingAddress'],
									  "editMode" => false,
									  "primaryKey" => 'ship_id',
									  "changeLink" => ($_SESSION['User']['cart_guest']==1)? 'guest_add' :'pre_checkout_shipping',
									  "changeController" => ($_SESSION['User']['cart_guest'] == 1)? 'billing_addresses' : null
								));
						?>
						<input type="hidden" name="ship_id" id="ship_id" value="<?php echo $shippingAddress['ShippingAddress']['ship_id'] ?>"/>
					  	<input type="hidden" name="sstate" id="sstate" value="<?php echo $shippingAddress['ShippingAddress']['state'] ?>"/>
						<input type="hidden" name="szip" id="szip" value="<?php echo $shippingAddress['ShippingAddress']['zip'] ?>"/>
					</td>
					
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan='2'>
		
			<center>
				<div id="warning"><br><br>Please Note: The billing address must be the address on file with the credit card company for the card being used.</div>
			</center>
		</td>
	</tr>
</table>
</center>
<Br><Br>
<hr><Br>
<?php
	$areTherePogoItems = false;
	$isBackordered = false;
	foreach ($cartItems as $item)
	{ 
		echo $this->element('cart_item',array('item'=>$item));
	} 
	
	foreach ($coupons as $code=>$coupon){ 
		echo $this->element('cart_coupon',array('coupon'=>$coupon));?>
		<input type='hidden' value='<?php echo $coupon['Coupon']['description']?>' name='code[<?php echo $coupon['Coupon']['id']?>]'>	
<?php } 

	if ($gift)
	{
		echo $this->element('cart_gift_wrap',array('giftPrice'=>$giftPrice));
	} 
?>
<br><br>
<?php 
		$shipping_choice = null;
		if(isset($_SESSION['cart']['shipping_choice'])){
			$shipping_choice = $_SESSION['cart']['shipping_choice'];	
		}else{
			$shipping_choice = 1;	
		}
?>
<?php  echo $this->Form->input('ship_type',array('selected'=>$shippingTypes[$shipping_choice],
										    'options'=>$shippingTypes,
											'label'=>false,
											'class'=>'shipdate_note',
											'onchange'=>'getTotals(event)',
											'name'=>'data[ship_type]',
											'id'=>'ship_type')
						  )
?>
<div id="shipping_wrapper">								  
	<div id="shipping_loading">
		<div id="spinningWheel"><img src="<?php echo $secureRootDir?>img/ben_spinner.gif"/></div>
		<div id="shippingLoadingMessage"><span>Calculating Shipping...</span></div>
	</div>
	<div id="total_block_new">
				<?php if($areTherePogoItems || $isBackordered){ ?>
					<div class="shipdate_note">*Your order will ship on this date except for products 
										labeled with additional ship dates noted above:
					</div>
				<?php } ?>
				<div id="totals">
					<?php  
						echo $this->requestAction(array('controller' => 'orders', 'action' => 'get_totals'),
												  		array('pass'=>array($shippingAddress['ShippingAddress']['ship_id'], $shipping_choice),
												  			  'return'
												  		      )
												  );
					?>
				</div>
			
			<br><br><br>
			
			<div id="gift_options" style="background-image:url('<?php echo "{$secureRootDir}unique/{$siteConfig->site}" ?>/img/gift_options.jpg')">
				<div class="gift_text">
					<h3 style="display: inline-block;">CHECK OUT OUR GIFT OPTIONS!!</h3>
					<Br><br>
					<input type="checkbox" id="gift_wrap" name="gift_wrap" onclick="gift_wrap_func();"<?php if($gift){echo " checked";}?>>I want UGP to gift wrap my order for $5 per item.<br><span style="font-size:small; left:1.5em; position:relative;">*Note: All items will be individually wrapped</span>
					<Br><Br>
					<input type="checkbox" name="gift_receipt">I need a Gift Receipt
				</div>
			</div>
		
			<?php /* 
				<Br><Br>
				
				Follow us on <a href="http://twitter.com/UGPGoBlue" target="_blank">Twitter</a> or <a href="http://www.facebook.com/ugpannarbor" target="_blank">Facebook</a> for sales, giveaways, and promotions!<Br><Br>	
				<a href="http://twitter.com/UGPGoBlue" target="_blank"><img src="img/twitter.png" width="50" alt="Twitter"></a>
				<a href="http://www.facebook.com/ugpannarbor" target="_blank"><img src="img/facebook.png" width="50" alt="Facebook"></a>
				
				<Br><Br>
			*/ ?>
			
		<span class="text">Paying with a Debit Card? Read this <span id="link" style="font-size: medium;" onclick="window.open('PreAuth_Notice.php','Pre-Authorization Notice','width=500,height=500,toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,copyhistory=0,resizable=1')">important notice</span> about Potential Pre-Authorization Holds from your bank.</span>
		<Br><Br>
		
		<Br><Br>
		<div id="submit_btn">
			<input type="button" id="prepay_submit" value="Complete Payment" onclick="submit_filter();">
		</div>
		<br>
	</div>
	</div>
</form>
</div>
<script language="javascript">

	function getTotals(e){
		shipping_type = $('#ship_type').val();
		$('#total_block_new').hide(0);
		$('#shipping_loading').show(0);
		$.post('<?php echo $secureRootDir?>orders/get_totals/<?php echo $shippingAddress['ShippingAddress']['ship_id'] ?>/'+shipping_type, function(data) {
			$('#total_block_new').show(0);
			$('#shipping_loading').hide(0);
			$('#totals').html(data);
		});
					
	}

	function submit_checkout()
	{
		document.getElementById('submit_btn').innerHTML="<img src='<?php echo $secureRootDir?>img/ben_spinner.gif' alt='Processing...'>";
		document.getElementById('cart_frm').submit();
	}

	
	function submit_filter()
	{
		//filter no longer needed as calculated price is clearer.
		submit_checkout();
	}

	
	function gift_wrap_func()
	{
		if (document.getElementById('gift_wrap').checked)
		{
			window.location = "<?php echo Router::url(array('controller'=>'orders','action'=>'applygiftwrap'))?>";
			document.getElementById('submit_btn').innerHTML="<img src='<?php echo $secureRootDir?>img/ben_spinner.gif' alt='Processing...'>";
		}
		else
		{
			window.location = "<?php echo Router::url(array('controller'=>'orders','action'=>'removegiftwrap'))?>";
			document.getElementById('submit_btn').innerHTML="<img src='<?php echo $secureRootDir?>img/ben_spinner.gif' alt='Processing...'>";
		}
	}

	function ctype_decide()
	{
	  var choice = document.getElementById('ctype_dropdown').options[document.getElementById('ctype_dropdown').selectedIndex].value;
	  
	  if (choice == "Visa")
	  {
	    cardFixVisa();
	  }
	  else if (choice == "MasterCard")
	  {
	    cardFixMasterCard();
	  }
	  else if (choice == "Discover")
	  {
	    cardFixDiscover();
	  }
	  else if (choice == "Amex")
	  {
	    cardFixAmex();
	  }
	  else
	  {
	    alert("There is an error with your card type selection.");
	  }
	}

	function cardFixVisa()
	{
	  document.getElementById('cvv2').size=3;
	  document.getElementById('cnum').innerHTML = '<input type="text" name="cnumber1" id="cnumber1" size="4" maxlength="4"> - <input type="text" name="cnumber2" id="cnumber2" size="4" maxlength="4"> - <input type="text" name="cnumber3" id="cnumber3" size="4" maxlength="4"> -  <input type="text" name="cnumber4" id="cnumber4" size="4" maxlength="4">';
	}

	function cardFixMasterCard()
	{
	  document.getElementById('cvv2').size=3;
	  document.getElementById('cnum').innerHTML = '<input type="text" name="cnumber1" id="cnumber1" size="4" maxlength="4"> - <input type="text" name="cnumber2" id="cnumber2" size="4" maxlength="4"> - <input type="text" name="cnumber3" id="cnumber3" size="4" maxlength="4"> -  <input type="text" name="cnumber4" id="cnumber4" size="4" maxlength="4">';
	}

	function cardFixDiscover()
	{
	  document.getElementById('cvv2').size=3;
	  document.getElementById('cnum').innerHTML = '<input type="text" name="cnumber1" id="cnumber1" size="4" maxlength="4"> - <input type="text" name="cnumber2" id="cnumber2" size="4" maxlength="4"> - <input type="text" name="cnumber3" id="cnumber3" size="4" maxlength="4"> -  <input type="text" name="cnumber4" id="cnumber4" size="4" maxlength="4">';
	}

	function cardFixAmex()
	{
	  document.getElementById('cvv2').size=4;
	  document.getElementById('cnum').innerHTML = "<input type='text' name='cnumber1' id='cnumber1' size='4' maxlength='4'> - <input type='text' name='cnumber2' id='cnumber2' size='6' maxlength='6'> - <input type='text' name='cnumber3' id='cnumber3' size='5' maxlength='5'><input type='hidden' name='cnumber4' id='cnumber4' value=''>";
	}
		
</script>
