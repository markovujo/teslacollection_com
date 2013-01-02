<div class="selection_box">
    <label for="<?php echo $selection_id; ?>"><?php echo $selection_name; ?>:</label>
    <?php echo $this->Form->input($selection_id, array(
    	'class' => 'chzn-select'
    	, 'options' => $options
    	, 'label' => false
    	, 'div' => array(
    		'class' => 'formSelection searchBox'
    	)
    )); ?>
    <div class="fix"></div>
</div>