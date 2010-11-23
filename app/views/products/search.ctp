<div class="paging paging-top">
<?php
//debug($this);
if($this->params['paging']['Product']['pageCount'] > 1){
	echo $formVariablesPaginator->counter(array(
		'format' => __('Page <strong>%page%</strong> of <strong>%pages%</strong> of %count% total items', true)
	));
}?>
</div>
<?php 
if($this->params['paging']['Product']['pageCount'] > 1){?>
	<div class="paging paging-bottom" style="clear:both">
		<?php echo $this->element('paging_selectors');?>
	</div>
	<div style="clear:both"></div>
<?php }
foreach ($products as $product){
	echo $this->element('product_rollover',array("product" => $product));
}
if($this->params['paging']['Product']['pageCount'] > 1){?>
	<div class="paging paging-bottom-bottom" style="clear:both">
		<?php echo $this->element('paging_selectors');?>
	</div>
	<div style="clear:both"></div>
<?php }
?>