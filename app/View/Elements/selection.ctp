<div class="selection_box" style="float: left; background-color: #CCCCCC;">
    <label for="<?php echo $selection_id; ?>"><?php echo $selection_name; ?>:</label>
    <?php
    echo $this->Form->input($selection_id, array(
    	'type' => 'select'
    	, 'multiple' => 'multiple'
    	, 'style' => 'width: 200px; height: 300px;'
    	, 'class' => 'selection-box'
    	, 'options' => $options
    	, 'label' => false
    	, 'div' => array(
    		'class' => 'formSelection searchBox'
    	)
    )); ?>
</div>