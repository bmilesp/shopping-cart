<br>
<div class="total_block_date">
Ship Date: <span id="ship_date_span"><?php echo date('F j, Y',strtotime($totals['shipDates']['shipDate']))?></span>
</div>
<div class="total_block_date">
In-Hands Date: <span id="inhands_date_span"><?php echo date('F j, Y',strtotime($totals['shipDates']['inHandsDate']))?></span>
</div>
Sub-Total: $<span id="subtotal_span"><?php echo number_format($totals['noTaxNoShipping'],2)?></span>
<br>
Shipping &amp; Handling: $<span id="ship_span"><?php echo number_format($totals['shippingPrice'],2)?></span>
<br>
Tax: $<span id="tax_span"><?php echo number_format($totals['totalTax'],2)?></span>
<br>
<?php if($totals['discount'] > 0){?>
	Discount: -$<span id="subtotal_span"><?php echo number_format($totals['discount'],2)?></span><br>
<?php } ?>
Total: $<span id="total_span"><?php echo number_format($totals['total'],2)?></span>
