<?php 
/** DoDirectPayment NVP example; last modified 08MAY23.
 *
 *  Process a credit card payment. 
*/
$man_sql = "SELECT * FROM carts.maintenance WHERE site_id = {$siteConfig->site_id}";
$man_query = mysql_query($man_sql) or die (mysql_error());
$man_row = mysql_fetch_array($man_query);
$NOT_LIVE = $man_row['paypal'];
$MAN_ADMIN = $man_row['admin_receipts'];
$MAN_INVENTORY = $man_row['retail_inventory'];
if ($NOT_LIVE)
{
	$environment = 'sandbox';	// or 'beta-sandbox' or 'sandbox'
}
else
{
	$environment = 'live';	// or 'beta-sandbox' or 'live'
}
/**
 * Send HTTP POST Request
 *
 * @param	string	The API method name
 * @param	string	The POST Message fields in &name=value pair format
 * @return	array	Parsed HTTP Response body
 */
function PPHttpPost($methodName_, $nvpStr_, $NOT_LIVE, $environment) {


	// Set up your API credentials, PayPal end point, and API version.
	if ($NOT_LIVE)
	{
		//Sandbox Credentials
		$API_UserName = urlencode('mercha_1228166125_biz_api1.alfajango.com');
		$API_Password = urlencode('1228166132');
		$API_Signature = urlencode('AiPC9BjkCyDFQXbSkoZcgqH3hpacAcujOjqHEgZRXSrbLlhVd6Omqb6d');
	}
	else
	{
		//Live Credentials
		
		$API_UserName = urlencode('ugpmichiganapparel_api2.undergroundshirts.com');
		$API_Password = urlencode('TH74N86JRA6ELQ5Z');
		$API_Signature = urlencode('AQMwTm.I3.QYFd204ZFRiRMSeqvNAbIOGncZ0HAU0GIRIrKrHu9UgV6I');
		
	}	
	$API_Endpoint = "https://api-3t.paypal.com/nvp";
	if("sandbox" === $environment || "beta-sandbox" === $environment)
	{
		$API_Endpoint = "https://api-3t.$environment.paypal.com/nvp";
	}
	
	$version = urlencode('51.0');

	// Set the curl parameters.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);

	// Turn off the server and peer verification (TrustManager Concept).
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);

	// Set the API operation, version, and API signature in the request.
	$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
	// Set the request as a POST FIELD for curl.
	curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

	// Get response from the server.
	$httpResponse = curl_exec($ch);

	if(!$httpResponse) {
		exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
	}

	// Extract the response details.
	$httpResponseAr = explode("&", $httpResponse);
	$httpParsedResponseAr = array();
	$httpParsedResponseAr["TRANSACTIONID"] = null;
	foreach ($httpResponseAr as $i => $value) {
		$tmpAr = explode("=", $value);
		if(sizeof($tmpAr) > 1) {
			$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
		}
	}
	
	if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
		exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
	}

	return $httpParsedResponseAr;
}

//////////////////////////

//get billing info
$q="SELECT * FROM billing where bill_id = '{$_REQUEST['bill_id']}'";
$r=mysql_query($q);
$billing = mysql_fetch_assoc($r);
	
// Set request-specific fields.
$paymentType = urlencode('Sale');				// or 'Authorization'
$firstName = urlencode($billing['firstname']);
$lastName = urlencode($billing['lastname']);
$creditCardType = urlencode($_REQUEST['ctype']);
$creditCardNumber = urlencode($_REQUEST['cnumber1'] . $_REQUEST['cnumber2'] . $_REQUEST['cnumber3'] . $_REQUEST['cnumber4']);
// Month must be padded with leading zero
$padDateMonth = urlencode(str_pad($_REQUEST['expmonth'], 2, '0', STR_PAD_LEFT));
$expDateYear = urlencode($_REQUEST['expyear']);
$cvv2Number = urlencode($_REQUEST['cvv2']);
$address1 = urlencode($billing['address_1']);
$addr2 = empty($billing['address_2']) ? " " : $billing['address_2'];
$address2 = urlencode($addr2);
$city = urlencode($billing['city']);
$state = urlencode($billing['state']);
$zip = urlencode($billing['zip']);
$country = urlencode('US');				// US or other valid country code
$total = number_format($_SESSION['cart']['totals']['total'], 2);
//echo "||" . $_REQUEST['datotal'] . "||";
$amount = urlencode($total);
$currencyID = urlencode('USD');			// or other currency ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')
$tax_rate = $_REQUEST['tax_rate'];
// Add request-specific fields to the request string.
$nvpStr =	"&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber".
			"&EXPDATE=$padDateMonth$expDateYear&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName".
			"&STREET=$address1&CITY=$city&STATE=$state&ZIP=$zip&COUNTRYCODE=$country&CURRENCYCODE=$currencyID";


if($environment == 'live'){
	//if test CC is being used, force the site into maintenance mode:
	if($creditCardNumber == '4663572426814263'){
		$MAN_ADMIN = 1;
		$NOT_LIVE = 1;
		$environment = 'sandbox';
	}
}


// Execute the API operation; see the PPHttpPost function above.
$httpParsedResponseAr = PPHttpPost('DoDirectPayment', $nvpStr, $NOT_LIVE, $environment);
$trans_id = ($total == 0)?"00000000000000000":$httpParsedResponseAr["TRANSACTIONID"];

$_SESSION['transaction_id'] = $trans_id;

if(("Success" == $httpParsedResponseAr["ACK"]) || (($total == 0) && ($_REQUEST['cart_size'] > 0))) 
{
	$tax = number_format($_SESSION['cart']['totals']['totalTax'], 2);
	$shipping = number_format($_SESSION['cart']['totals']['shippingPrice'], 2);
	
	$cfname = $billing['firstname'];
	$clname = $billing['lastname'];
	$cemail = $_REQUEST['cemail'];
	$cphone = $_REQUEST['cphone'];
	
	//get shipping info:
	$q="SELECT * from shipping where ship_id = ".$_REQUEST['ship_id'];
	$r = mysql_query($q);
	$shippingAddress = mysql_fetch_assoc($r);
	
	$sfname = $shippingAddress['firstname'];
	$slname = $shippingAddress['lastname'];
	$sadd1 = $shippingAddress['address_1'];
	$sadd2 = $shippingAddress['address_2'];
	$scity = $shippingAddress['city'];
	$sstate = $shippingAddress['state'];
	$szip = $shippingAddress['zip'];
	
	//echo "<Br><br>" . $_SESSION['size'] . "<Br><br>";
	
	$ship_type = $_SESSION['cart']['shipping_code']['title'];
	
	//echo "<Br><br>||" . $ship_type . "||<Br><br>";
	
	$is_usps = ($ship_type=="USPS")?1:0;
	
	$gift_wrap = isset($_REQUEST['gift_wrap'])?1:0;
	$gift_receipt = isset($_REQUEST['gift_receipt'])?1:0;
	$newsletter = isset($_REQUEST['newsletter'])?1:0;
	
	//for receipt:
	for ($i = 0; $i < $_REQUEST['cart_size']; $i++)
	{
		if(!($_REQUEST['U_id' . $i] || 
			($_REQUEST['B_id' . $i] && !$_REQUEST['O_id' . $i]) || 
			($_REQUEST['AB_id' . $i] && !$_REQUEST['O_id' . $i])
		)){ $cart[] = array("id" => $_REQUEST['id' . $i], "name" => urldecode($_REQUEST['name' . $i]), "price" => $_REQUEST['price' . $i], 
		"qty" => $_REQUEST['qty' . $i], "size" => $_REQUEST['size' . $i], "color_id" => $_REQUEST['color_id' . $i]); }	
	}

	$prod_subtotal = $_SESSION['cart']['totals']['noTaxNoShipping'];
	$gift_price = $_SESSION['cart']['totals']['giftWrapTotal'];
	$discount = isset($_SESSION['cart']['totals']['discount'])? $_SESSION['cart']['totals']['discount'] : 0.00;
	
	/******************************************************************************************/
	$oq = "INSERT INTO carts.orders (site_id, ship_id, bill_id, user_id, transactionID, date_created, total, ship_total, tax_total, prod_subtotal, checker, ship_type, is_usps, gift_wrap, gift_receipt, in_hands_date, discount_total) VALUES ({$siteConfig->site_id},{$shippingAddress['ship_id']},{$billing['bill_id']},{$user['User']['id']}, '$trans_id', NOW(), $total, $shipping, $tax, $prod_subtotal, '0', '$ship_type', $is_usps, $gift_wrap, $gift_receipt, '$dbInHandsDate', '$discount')";

	mysql_query($oq) or die (mysql_error() . "<Br><BR>Insert into orders");
	
	$order_id = mysql_insert_id();

	/******************************************************************************************/
	if(!empty($coupons)){
		foreach($coupons as $key=>$coupon){
			$opq = "INSERT INTO carts.coupons_used (disc_id, order_id, message) VALUES ({$coupon['Coupon']['id']}, $order_id, '{$coupon['Coupon']['description']}')";
			mysql_query($opq) or die (mysql_error() . "<Br><BR>Insert into coupons_used");
			
			if(isset($coupon['Groupon']) && !empty($coupon['Groupon'])){
				$gq = "UPDATE groupon SET status = 'Redeemed', redeemed_at = NOW() WHERE id = '{$coupon['Groupon']['id']}';";
				mysql_query($gq) or die (mysql_error() . "<Br><BR>Insert into groupon");
			}
		}
	}
	
		
	/******************************************************************************************/

//echo "<Br><br>" . sizeof($cart) . "<Br><br>";

	for ($i = 0; $i < sizeof($cart); $i++)
	{
		$op_sql = "INSERT INTO carts.orders_products (order_id, prod_id, name, size, qty, color_id, price) 
		VALUES ($order_id, " . $cart[$i]["id"] . ", '" . urlencode($cart[$i]["name"]) . "', '" . 
		$cart[$i]["size"] . "', " . $cart[$i]["qty"] . ", " . $cart[$i]["color_id"] . ", " . $cart[$i]["price"] . ");";
		
		//echo "<Br><br>" . $op_sql . "<Br><br>";
		
		mysql_query($op_sql) or die (mysql_error() . "<Br><Br>Insert into orders_products");
		
		$pogo_query = mysql_query("SELECT pogo_id FROM products WHERE id=" . $cart[$i]["id"] ." AND site_id = {$siteConfig->site_id}");
		$pogo_row = mysql_fetch_array($pogo_query);
		
		$pogo_id = $pogo_row['pogo_id'];
		
		if (!empty($pogo_id))
		{
			include("pogo_link.php");
		}
	}

	$to = "billing@undergroundshirts.com";
	$to .= ", btalavera@undergroundshirts.com";
	
	//$to = "btalavera@undergroundshirts.com";
	
	$body = "<html><body>$cfname $clname has bought from " . $siteConfig->getCartDBField('customers_email_receipt_from_address') . ".<br><br><B>ORDER #</B>: " . $order_id . "<br><br><B>TRANSACTION ID</B>: $trans_id<br><br></html></body>";
	$from = $siteConfig->getCartDBField('customers_email_receipt_from_address');
	$headers  = "From: $from\r\n";
	$headers .= "Content-type: text/html\r\n";

	mail($to, "Payment for $cfname $clname, Order #" . $order_id, $body, $headers);
	
	if($NOT_LIVE){
		echo "<font style='color:red;size:24px;font-weight:bold'>TRANSACTION NOT COMPLETED: THE SITE IS CURRENTLY IN MAINTENANCE MODE. PLEASE CONTACT CUSTOMER SERVICE AT 1-800-242-4787 TO COMPLETE THIS TRANSACTION. SORRY FOR THE INCONVENIENCE.</font>";
	}
	
	if (!$MAN_ADMIN)
	{
		include("admin_connect.php");
	}

	include("receipt.php");
}
else  
{	
		
	
	$daErrCode = urldecode($httpParsedResponseAr["L_ERRORCODE0"]);
	$daMessage = urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]);

	if ($daErrCode == "15005")
	{
		$error_msg = "Your transaction has been <strong>DECLINED</strong> by the issuing credit card company. Reason for Decline: Insufficient funds or invalid card. Please try another card or check that you entered your information correctly.";
	}
	else if ($daErrCode == "15006")
	{
		$error_msg = "Your transaction has been <strong>DECLINED</strong> by the issuing credit card company. Reason for Decline: Insufficient funds or invalid card. Please try another card or check that you entered your information correctly.";
	}
	else if ($daErrCode == "15007")
	{
		$error_msg = "Your transaction has been <strong>DECLINED</strong> by the issuing credit card company. Reason for Decline: Expired card. Please try another card or provide another method of payment for your order.";
	}
	else
	{
		$error_msg = $daErrCode . " - " . $daMessage;
	}

	$paypal_return_amt = $httpParsedResponseAr["AMT"];
	if (empty($paypal_return_amt)) {$paypal_return_amt="0.00";}
	
	$error_sql = "INSERT INTO carts.paypal_errors (error_code, message, time_stamp, mgo_amt, paypal_amt) VALUES (" . $daErrCode . ", '" . urlencode($daMessage) . "', NOW(), " . urlencode($amount) . ", " . $paypal_return_amt . ")";
	
	//echo "<Br><br>" . $error_sql . "<Br><br>";
	
  	mysql_query($error_sql) or die (mysql_error() . "<br><br>Insert into prepay_errors");
	
  	$customerContactEmail = $siteConfig->getCartDBField('customer_contact_email');
  	?>             
	      <div id="oops">                 
	        <center>
				<div id="title">OOPS!</div>                     
				<br>
				<br>
				Looks like something's wrong:<Br><br><div class="normal_width"><?php echo $error_msg; ?></div><br><br>
				
				<?php echo $this->Form->create('Edit',array('url' => $this->Html->url(array('controller'=>'orders','action'=>'checkout'),true,true),'class'=>'nav2'));?>
					<input class="nav2_button" type="submit" value="GO BACK AND TRY AGAIN">
				</form>
			<br>
			<br>
			<div class="small normal_width">If you are unable to complete a transaction after several attempts please call (734) 665-2692 or e-mail us at <a href="mailto:<?php echo $customerContactEmail ?>"><?php echo $customerContactEmail ?></a>.  Be sure to tell us the entire Reason for Decline listed above. Thank you.</div>
			<br>
			<Br>
		</center>
	</div>
<?php } ?>