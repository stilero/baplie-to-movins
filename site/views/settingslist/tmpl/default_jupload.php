<?php

/**
 * @version     $Id$
 * @copyright   Copyright 2011 Stilero AB. All rights re-served.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
//No direct access
defined('_JEXEC) or die;');

//Import filesystem libraries. Perhaps not necessary, but does not hurt
jimport('joomla.filesystem.file');
 

$user_names = '';
$portsOfLoading = '';
$file = JRequest::getVar('file_upload', null, 'files', 'array'); 
$classPath = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_convertbapliemovins'.DS.'classes'.DS.'edi'.DS;
JLoader::register('EdiBaplie', $classPath.'edibaplie.php');
JLoader::register('EdiMessage', $classPath.'edimessage.php');
foreach (glob($classPath."edielements".DS."*.php") as $filename){
    require_once $filename;
}
if( isset($file) ){ 
    $msg = handleUpload( $file );
    //var_dump($msg);exit;
    $app =& JFactory::getApplication();
    if($msg['type'] != ''){
        $url = 'index.php?option='.JRequest::getVar('option').'&view='.JRequest::getVar('view').'';
        $app->redirect($url, $msg['msg'], $msg['type']);
    }else{
        $app->enqueueMessage( $msg['msg'], $msg['type'] );
    }
    //showMovinsForm();
}


function handleUpload($file){
    $app =& JFactory::getApplication();
    $max = ini_get('upload_max_filesize');
    $module_dir = JPATH_SITE.DS.'tmp';
    $file_type = '*';
    $fileExtensions = array('edi','mov','txt');
    $msg = array();
    $filename = JFile::makeSafe($file['name']);
    if($file['size'] > $max){
        $msg['msg'] = JText::_('ONLY_FILES_UNDER').' '.$max;
        $msg['type'] = 'error';
    }
    $tmpFile = $file['tmp_name'];
    
    $filename = JFile::makeSafe($file['name']);
    $fileID = uniqid();
    $tempFileName = $fileID.'.edi';
    //Set up the source and destination of the file
    $src = $file['tmp_name'];
    $dest = JPATH_COMPONENT . DS . "uploads" . DS . $tempFileName;
    if(!in_array(JFile::getExt($filename), $fileExtensions) ){
         $msg['msg'] = JText::_('WRONG_FILETYPE');
         $msg['type'] = 'error';
         
         return $msg;
    }
    JFile::upload($src, $dest);
    $ediData = file_get_contents($dest);
    $baplie = new EdiBaplie($ediData);
    $portsOfLoading = $baplie->fetchPortsOfLoading();
   
    $msg['msg'] = JText::_('FILE_UPLOADED');
    $msg['type'] = '';
    foreach ($portsOfLoading as $port) {
        print "<a href=\"index.php?option=com_convertbapliemovins&view=movins&pol=".$port."&token=".$fileID."\">".JTEXT::_('DOWNLOAD_FOR_POL')." ".$port."</a></br>";
    }
    return $msg;
}

function showMovinsForm(){
    foreach ($portsOfLoading as $port) {
        print $port;
    }
}

?>