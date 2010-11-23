<?php echo $this->element('address_label', 
							array("data" => $billingAddress,
								  "editMode" => false,
								  "selectMode" => false,
								  "primaryKey" => 'bill_id',
								  "controller" => 'billing_addresses'
							));
?>