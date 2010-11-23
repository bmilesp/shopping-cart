<?php
$prod_sub = number_format($prod_subtotal, 2);
$tax = number_format($tax, 2);
$total = number_format($total, 2);

$subtotal = $total - $tax - $shipping;

$sid = 1;
$customer_uid = $user['User']['id'];
$adminzip = substr(preg_replace("/[^0-9]/", '', $szip), 0, 5);

//$order_id from insert orders query in Direct Payment.php:
mysql_query("INSERT INTO admin.retail_sales (prod_subtotal, shipping, tax, total, tax_rate, store_id, transaction_date, customer_id, site_id, cart_order_id, zip) VALUES ('$prod_sub', '$shipping', '$tax', '$total', '$tax_rate', '$sid', NOW(), '$customer_uid', '{$siteConfig->site_id}', '$order_id', '$adminzip');") or die (mysql_error() . "<br><br>Query failed retail_sales table INSERT in admin_connect.php");

$sales_sql = "SELECT sale_id FROM admin.retail_sales WHERE prod_subtotal='" . $prod_sub . "' AND tax='" . $tax . "' AND total='" . $total . "' AND site_id='{$siteConfig->site_id}' AND store_id='" . $sid . "' AND customer_id='" . $customer_uid . "' ORDER BY sale_id DESC LIMIT 1";

$sales_query = mysql_query($sales_sql) or die (mysql_error() . "<br><br>Query failed admin.retail_sales SELECT table in MAS_process.php");

$sale_row = mysql_fetch_array($sales_query);

$sale_id = $sale_row['sale_id'];

for ($i = 0; $i < sizeof($cart); $i++)
{
	$sku_sql = "SELECT RPS.id as sku, RI.item_name, RPS.cost, RI.retail_id FROM admin.retail_product_sizes RPS JOIN carts.colors_products CP ON (CP." . $cart[$i]["size"] . " = RPS.id) JOIN admin.retail_items RI USING (retail_id) WHERE CP.color_id=" . $cart[$i]["color_id"] . " AND CP.prod_id=" . $cart[$i]["id"];
	$sku_query = mysql_query($sku_sql) or die (mysql_error() . "<br><br>Query failed admin.retail_sales SELECT table in MAS_process.php");
	$sku_row = mysql_fetch_array($sku_query);
	
	//echo "<Br><br>" . $sku_sql . "<br><Br>";
	
	$sku = $sku_row['sku'];
	$iname = $sku_row['item_name'];
	$size = $cart[$i]["size"];
	$cost = $sku_row['cost'];
	$retail_id = $sku_row['retail_id'];
	$qty = $cart[$i]["qty"];
	$inv_cost_total = 0;
	
	$qty_sold_sql = "SELECT qty_sold, license_percent, retail_id FROM admin.retail_product_sizes WHERE id='" . $sku . "'";

	$qty_sold_query = mysql_query($qty_sold_sql) or die (mysql_error() . "<br><br>Query failed admin.retail_product_sizes SELECT table in MAS_process.php");

	$qty_sold_row = mysql_fetch_array($qty_sold_query);

	$license_percent = $qty_sold_row['license_percent'];
	
	$retail_id = $qty_sold_row['retail_id'];

	$qty_sold = $qty_sold_row['qty_sold'] - $qty;
	
	//echo $qty_sold . "<Br><br>";

	for ($j=$qty; $j > 0; $j--)
	{
		$pool_sql = "SELECT inv_cost, qty FROM admin.retail_stock_pools WHERE retail_product_size_id='" . $sku . "' ORDER BY created ASC";

		$pool_query = mysql_query($pool_sql) or die (mysql_error() . "<br><br>Query failed admin.retail_stock_pools SELECT table in MAS_process.php");
		
		$current = $j + $qty_sold;
		
		//echo $current;
		
		while ($pool_row = mysql_fetch_array($pool_query))
		{
			$current -= $pool_row['qty'];
			
			if ($current <= 0)
			{
				$inv_cost_total += $pool_row['inv_cost'];
				break;
			}
		}
	}
	
	$inv_cost = $inv_cost_total / $qty;
	
	if ($license_percent == 0)
	{
		$license_sql = "SELECT license_percent FROM admin.retail_items WHERE retail_id='" . $retail_id."'";
		
		//echo "<br><Br>" . $license_sql . "<br><Br>";

		$license_query = mysql_query($license_sql) or die (mysql_error() . "<br><br>Query failed retail_items SELECT table in MAS_process.php");
		
		$license_row = mysql_fetch_array($license_query);
		
		$license_percent = $license_row['license_percent'];
	}
	
	
	mysql_query("INSERT INTO admin.retail_sales_items (sale_id, retail_product_size_id, cost, qty, item_name, size, inv_cost, license_percent) VALUES ('$sale_id', '$sku', '$cost', '$qty', '$iname', '$size', '$inv_cost', '$license_percent');") or die (mysql_error() . "<br><br>Query failed retail_sales_items table INSERT in MAS_process.php");
	
	///--ITEM INVENTORY---////
	$qty_query = mysql_query("SELECT RPS.qty_sold, RPS.reorder_point, RPS.reorder_amount, RPS.retail_id, RPS.manual_percent, RPS.store_id, RPS.size_id, RI.item_name FROM admin.retail_product_sizes RPS LEFT JOIN admin.retail_items RI USING (retail_id) WHERE id=$sku;");
	
	if(!$MAN_INVENTORY && $qty_query!=false && empty($pogo_id))
	{
		$qty_row = mysql_fetch_array( $qty_query );
	
		$old_qty = $qty_row['qty_sold'];
		$RP = $qty_row['reorder_point'];
		$RA = $qty_row['reorder_amount'];
		$RID = $qty_row['retail_id'];
		$percent = $qty_row['manual_percent'];
		$STID = $qty_row['store_id'];
		$SID = $qty_row['size_id'];
		$item_name = $qty_row['item_name'];
	
		$new_qty = ($old_qty + $qty);
	
		$result3 = mysql_query("UPDATE admin.retail_product_sizes SET qty_sold=$new_qty WHERE id=$sku;") or die (mysql_error() . "<Br><Br>retail_product_sizes UPDATE table in MAS_process.php");
	
		$RP_query = mysql_query("SELECT OPS.quantity
	                         FROM admin.orders O
	                         JOIN admin.orders_products_sizes OPS ON (O.id = OPS.order_id)
	                         JOIN admin.orders_shipping_address OSA ON (O.id = OSA.order_id)
	                         JOIN admin.sizes S ON (S.size = OPS.size)
	                         WHERE O.retail_id=$RID AND (O.created IS NULL) AND OSA.store_id=$STID AND S.id=$SID;") or die (mysql_error() . "<Br><Br>O JOIN OPS JOIN JOIN OSA JOIN S SELECT table in MAS_process.php");
	
		$in_inventory = 0;
	
		while($RP_row = mysql_fetch_array( $RP_query ))
		{
	  		$in_inventory += $RP_row['quantity'];

		}

		$RP2_query = mysql_query("SELECT SUM(qty) AS total_qty
								  FROM admin.retail_stock_pools
								  WHERE retail_product_size_id = $sku;") or die (mysql_error() . "<Br><Br>admin retail_stock_pools SELECT table in MAS_process.php");
	
		$RP2_row = mysql_fetch_array( $RP2_query );
	
		$in_inventory += $RP2_row['total_qty'];
	
		$daSize_query = mysql_query("SELECT size
								  FROM admin.sizes
								  WHERE id = $SID;") or die (mysql_error() . "<Br><Br>sizes SELECT table in MAS_process.php");
	
		$daSize_row = mysql_fetch_array( $daSize_query );
	
		$daSize = $daSize_row['size'];

	//echo "IN Inventory: " . $in_inventory . "<br>";
	//echo "New Qty: " . $new_qty . "<br>";

		$in_inventory -= $new_qty;

	  	if (empty($percent))
	  	{
	  	  $percent_query = mysql_query("SELECT retail_ra_percent FROM admin.stores WHERE id=$sid;") or die (mysql_error() . "<Br><Br>stores SELECT table in admin_connect.php");

	  		$percent_row = mysql_fetch_array( $percent_query );

	  		$percent = $percent_row['retail_ra_percent'];
	  	}

	  	$limit = $RP + ($percent/100) * $RA;
	  	//echo "Limit: " . $limit . "<br>";

	  	$send = false;

	  	if ($in_inventory <= $RP)
	  	{
	  	  $subject = "SKU $sku - $daSize - RED Level Warning";
	  	  $body = "SKU <a href='http://admin.undergroundshirts.com/retailitems/edit/$RID'>$sku - $item_name</a> has reached its reorder point!!!";
	  	  $send = true;
	  	}
	  	else if ($in_inventory <= $limit)
	  	{
	  	  $subject = "SKU $sku - $daSize - YELLOW Level Warning";
	  	  $body = "SKU <a href='http://admin.undergroundshirts.com/retailitems/edit/$RID'>$sku - $item_name</a> is getting close to it's reorder point!!!";
	  	  $send = true;
	  	}

	  	$headers  = "From: RETAIL_Warnings@undergroundshirts.com\r\n";
	  	$headers .= "Content-type: text/html\r\n";

	  	if ($send)
	  	{
	  	  mail("ryan@undergroundshirts.com, mlong@undergroundshirts.com", $subject, $body, $headers);
	  	}
	}
	
	///---END ITEM INVENTORY---///
}

//PAYMENT
/*
$arr = str_split($daCC);

switch ($arr[0])
{
	case "3":
		$info = "AMEX";
		break;
	case "4":
		$info = "VISA";
		break;
	case "5":
		$info = "MC";
		break;
	case "6":
		$info = "DISC";
		break;
	default:
		$info = "Unknown";
}

$expmnth = $expDateMonth;
$expyr = $expDateYear;
*/
$info = $_REQUEST['ctype'] . "_" . $_REQUEST['expmonth'] . "_" . $_REQUEST['expyear'];

$transaction_id = $trans_id;

mysql_query("INSERT INTO admin.retail_sales_payments (sale_id, type, amount, info, transaction_id) VALUES ('$sale_id', 'CCS', '$amount', '$info', '$transaction_id');") or die (mysql_error() . "<br><br>Query failed retail_sales_payments table INSERT in admin_connect.php");

//END PAYMENT
?>