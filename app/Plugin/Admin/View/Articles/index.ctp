<?php echo $this->Html->script('/admin/js/teslacollection/articles.js', $options = array('plugin' => 'admin')); ?>
<?php //echo $this->Html->script('/admin/js/teslacollection/array-grid.js', $options = array('plugin' => 'admin')); ?>

<h1>Cell Editing Grid Example</h1>
<ul>
  <li>This example shows how to enable users to edit the contents of a grid.</li>
  <li>Note that the js is not minified so it is readable. See <a href="cell-editing.js">cell-editing.js</a>.</li>
  <li>This example also illustrates how to scope ExtJS's CSS reset to only encapsulate each ExtJS Component rendered into a page to avoid interference with existing themes.</li>
  <li>Note how this unordered list retains default styling while the unordered list in the "Light" dropdown is styled as a picker.</li>
</ul>

<div id="grid-example"></div>
<div id="editor-grid"></div>
