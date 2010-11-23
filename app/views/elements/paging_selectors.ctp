<div class='prevWrapper'><?php echo $formVariablesPaginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?></div>
<div class='pageNumbers'><?php echo $formVariablesPaginator->numbers();?></div>
<div class='nextWrapper'><?php echo $formVariablesPaginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?></div>
<div class='showAll'><?php echo $formVariablesPaginator->link('Show All',array('pages'=>'showAll'))?></div>