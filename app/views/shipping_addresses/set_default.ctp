<div id="address_label_container_<?php echo $address['ship_id']?>">
<?php echo $this->element('address_label', 
								array("data" => $address,
									  "editMode" => true,
									  "primaryKey" => 'ship_id'
								));
	///for ajax only, not used currently
?>
</div>