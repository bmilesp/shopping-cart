<table class='cart_item'>
		<tr>
			<td>
				<?php 	//leave static url in here for emails!
						echo $html->image("{$secureRootDir}img/coupon.png")?>
			</td>
		<td>
			<span style='font-size: large; color: #f00; font-weight: bold;'>Coupon:</span><Br><br><?php echo urldecode($coupon['Coupon']['description']) ?>
		</td>
			<td>
				&nbsp;
			</td>	
		</tr>
	</table>