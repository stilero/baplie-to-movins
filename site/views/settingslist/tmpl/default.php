<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
$file = JRequest::getVar('file_upload', null, 'files', 'array'); 
?>
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"><h2><?php echo $this->params->get('page_title');  ?></h2></div>

<div class="contentpane">
        <?php if(isset($file)){ ?>
            <?php echo $this->loadTemplate('jupload'); ?>
        <?php }else{ ?>
            <p><?php echo JText::_('CONVERT_DESC'); ?></p>
            <?php echo $this->loadTemplate('uploadform'); ?>
        <?php } ?>
	
</div>