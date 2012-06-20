<?php

/**
 * @version     $Id$
 * @copyright   Copyright 2011 Stilero AB. All rights re-served.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
//No direct access
defined('_JEXEC) or die;');
?>
<div id="adminForm">
<form name="imgform" method="post" action="" enctype="multipart/form-data" onSubmit="if(file_upload.value=='') {alert('Choose a file!');return false;}">
    <?php echo JText::_('CHOOSE_FILE'); ?> <input type="file" name="file_upload" size="30" />
    <input name="submit" type="submit" value="Upload" />
</form>
</div>