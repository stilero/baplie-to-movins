<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
header('Content-Disposition: attachment; filename="movins_'.$this->get('pol').'_'.time().'.edi"');
echo $this->get('ediData');
exit;
?>