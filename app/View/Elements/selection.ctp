<div class="selection_box">
    <label for="<?php echo $selection_id; ?>"><?php echo $selection_name; ?>:</label>
    <?php 
    //$options = array_merge(array('ALL' => ' -- ALL --'), $options);
    echo $this->Form->input($selection_id, array(
    	'type' => 'select'
    	, 'multiple' => 'multiple'
    	, 'class' => 'selection-box'
    	, 'options' => $options
    	, 'label' => false
    	, 'div' => array(
    		'class' => 'formSelection searchBox'
    	)
    )); ?>
    <div class="fix"></div>
</div>