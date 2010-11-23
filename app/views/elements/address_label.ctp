<?php 

	if(!isset($controller)){
		$controller = "shipping_addresses";
	}
	
	if(!isset($selectMode)){
		$selectMode = false;
	}
	
	if (!isset($primaryKey)){
		$primaryKey = null;
	}
	
	if(!isset($changeLink)){
		$changeLink = false;
	}
	
	if(!isset($changeController)){
		$changeController = 'users';
	}
?>
<div class='shipping_label <?php echo ($editMode)? ( ($data['default'] == 1)? 'defaulted' : null ) : 'defaulted' ?> '>
	<div class='shipping_label_right'>
		<?php if($editMode){
				
				if($data['default'] == 0){
					echo $html->link('Make Default',
								array( 'controller' => $controller, 'action' => 'set_default', $data[$primaryKey] )
							); 

					echo $html->link(__('Remove', true), array('controller'=>$controller,'action' => 'delete', $data[$primaryKey]), null, __('Are you sure you want to delete this Address?', true)); 
				}else{
					echo "<span class='label_default'>Default</span>";
				}
		} 
		if($selectMode){
			echo $html->link('Select This Address',
				array( 'controller' => 'users', 'action' => "{$controller}_select", $data[$primaryKey] )
			);
			
		} 
		
		if($changeLink){
			echo $html->link('Change',
				array( 'controller' => $changeController, 'action' => $changeLink )
			);
		}
		?>
	</div>
	<div class='shipping_label_left'>
		<?php 
			if($primaryKey){
				echo $form->input($primaryKey,array('type'=>'hidden','value'=>$data[$primaryKey]));
			} 
		?>
		<h1><?php echo $data['firstname']." ".$data['lastname'] ?></h1>
		<p>
			<?php echo $data['address_1'] ?><br>
			<?php echo $data['address_2'] ?><br>
			<?php echo $data['city'].", ".$data['state']." ".$data['zip'] ?>
		</p>
	</div>
</div>