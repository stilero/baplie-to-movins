<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
$this->loadTemplate('header');
$this->loadTemplate('filehandling');

?>
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"><h2><?php echo $this->params->get('page_title');  ?></h2></div>

<div class="contentpane">
	<?php echo $this->loadTemplate('uploadform'); ?>
</div>