<div class="selection_text_box" style="float: left; background-color: #CCCCCC;">
    <label for="<?php echo $selection_id; ?>"><?php echo $selection_name; ?>:</label>
    <?php
    echo $this->Form->input($selection_id, array(
    	'type' => 'text',
    	'name' => $name,
    	'label' => false,
        'style' => 'width: 200px;'
    )); ?>
    <div class="fix"></div>
</div>