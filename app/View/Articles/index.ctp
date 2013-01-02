<?php
	debug($selections); 
	die(); 
	
	
?>

<div class="selection_box">
    <label for="author_id">Author:</label>
    <?php echo $this->Form->input('author_id', array('class' => 'chzn-select', 'options' => $languageOptions, 'label' => false, 'div' => array('class' => 'formRight noSearch'))); ?>
    <div class="fix"></div>
</div>