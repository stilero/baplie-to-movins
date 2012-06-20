<?php

/**
 * @version     $Id$
 * @copyright   Copyright 2011 Stilero AB. All rights re-served.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
//No direct access
defined('_JEXEC) or die;');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

//this is the name of the field in the html form, filedata is the default name for swfupload
//so we will leave it as that
$fieldName = 'Filedata';

//any errors the server registered on uploading
$fileError = $_FILES[$fieldName]['error'];
if ($fileError > 0) 
{
        switch ($fileError) 
        {
        case 1:
        echo JText::_( 'FILE TO LARGE THAN PHP INI ALLOWS' );
        return;

        case 2:
        echo JText::_( 'FILE TO LARGE THAN HTML FORM ALLOWS' );
        return;

        case 3:
        echo JText::_( 'ERROR PARTIAL UPLOAD' );
        return;

        case 4:
        echo JText::_( 'ERROR NO FILE' );
        return;
        }
}

//check for filesize
$fileSize = $_FILES[$fieldName]['size'];
if($fileSize > 2000000)
{
    echo JText::_( 'FILE BIGGER THAN 2MB' );
}

//check the file extension is ok
$fileName = $_FILES[$fieldName]['name'];
$uploadedFileNameParts = explode('.',$fileName);
$uploadedFileExtension = array_pop($uploadedFileNameParts);

$validFileExts = explode(',', 'jpeg,jpg,png,gif');

//assume the extension is false until we know its ok
$extOk = false;

//go through every ok extension, if the ok extension matches the file extension (case insensitive)
//then the file extension is ok
foreach($validFileExts as $key => $value)
{
        if( preg_match("/$value/i", $uploadedFileExtension ) )
        {
                $extOk = true;
        }
}

if ($extOk == false) 
{
        echo JText::_( 'INVALID EXTENSION' );
        return;
}

//the name of the file in PHP's temp directory that we are going to move to our folder
$fileTemp = $_FILES[$fieldName]['tmp_name'];

//for security purposes, we will also do a getimagesize on the temp file (before we have moved it 
//to the folder) to check the MIME type of the file, and whether it has a width and height
$imageinfo = getimagesize($fileTemp);

//we are going to define what file extensions/MIMEs are ok, and only let these ones in (whitelisting), rather than try to scan for bad
//types, where we might miss one (whitelisting is always better than blacklisting) 
$okMIMETypes = 'image/jpeg,image/pjpeg,image/png,image/x-png,image/gif';
$validFileTypes = explode(",", $okMIMETypes);		

//if the temp file does not have a width or a height, or it has a non ok MIME, return
if( !is_int($imageinfo[0]) || !is_int($imageinfo[1]) ||  !in_array($imageinfo['mime'], $validFileTypes) )
{
        echo JText::_( 'INVALID FILETYPE' );
        return;
}

//lose any special characters in the filename
$fileName = preg_replace("/[^A-Za-z0-9]/i", "-", $fileName);

//always use constants when making file paths, to avoid the possibilty of remote file inclusion
$uploadPath = JPATH_SITE.DS.'images'.DS.'stories'.DS.$fileName;

if(!JFile::upload($fileTemp, $uploadPath)) 
{
        echo JText::_( 'ERROR MOVING FILE' );
        return;
}
else
{
   // success, exit with code 0 for Mac users, otherwise they receive an IO Error
   exit(0);
}