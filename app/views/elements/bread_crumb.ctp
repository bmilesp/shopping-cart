<?php  $spacer = "&nbsp;&nbsp;>&nbsp;&nbsp;"?>
<div class='bread-crumb'>
	<?php 
		$totalCrumbs = count($list);
		$i=1; 
		$keylist = array();
		foreach($list as $key=>$crumb){
			$keylist[] = $key;
			$all = ($i == 1)? $html->link('All',array_merge(array('controller'=>'products','action'=>'index'))). $spacer : null;
			if($i == $totalCrumbs){?>
				<h1><? echo $all ?><?php echo $crumb?></h1>
			<?php }else{?>
				<h1><?php echo $all ?><?php echo $html->link($crumb,array_merge(array('action'=>'tags'),$keylist)); echo $spacer?></h1>
			<?php }
			$i++;}?>
</div>
<div style="clear:both"></div>