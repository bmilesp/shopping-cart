<table>
	<tr>
	  <td style="border-right: 1px solid rgb(204, 204, 204);padding-left:0px;">
		<div id="product_spotlight">
			<?php echo $this->element('product/spotlight',array('product'=>$product,
																'prodImageUrl'=>$prodImgUrl))?>
		</div>
		
		<div style="clear:both"></div>
		<div id="product_description"  style="margin: auto ! important; width: 90% ! important; position: relative; text-align: left;">
			<?php echo urldecode($product['Product']['message2'])?>
		</div>
	  </td>
	  <td style="text-align: center;width:280px;  padding-left:20px; padding-right:30px;">
		  <h1><?php echo urldecode($product['Product']['name'])?></h1>
		  <hr style="border-width: 1px medium medium ! important; border-style: solid none none ! important; border-color: rgb(204, 204, 204) -moz-use-text-color -moz-use-text-color ! important;"><br>
		  <div>
			<?php echo $this->element('product/social')?>
		  </div>
			
			<div class="prod_message">
				<p style="text-align: center">
					<?php echo urldecode($product['Product']['message'])?>
				</p>
				<br>
				<?php if (isset($product['Product']['sizing_link']) && !empty($product['Product']['sizing_link'])){?>
					<a href='<?php echo urldecode($product['Product']['sizing_link']) ?>' target='_blank'>Click here for Sizing Info</a><Br>
				<?php }?>
			<br><br>
			</div>
			<br>
			<?php echo $this->element('product/selector')?>
	  </td>
	</tr>
</table>