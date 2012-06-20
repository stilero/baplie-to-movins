<?php

/**
 * @version     $Id$
 * @copyright   Copyright 2011 Stilero AB. All rights re-served.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
//No direct access
defined('_JEXEC) or die;');

//when we send the files for upload, we have to tell Joomla our session, or we will get logged out 
$session = & JFactory::getSession();
 
$swfUploadHeadJs ='
var swfu;
 
window.onload = function()
{
 
var settings = 
{
	flash_url : "'.$this->get('jsPath').'swf/swfupload.swf",
 
        //we can not put any vars into the url for complicated reasons, but we can put them into the post...
        upload_url: "index.php",
	post_params: 
	{
		"option" : "'.$this->get('component').'",
                "view" : "settingslist",
		"'.$session->getName().'" : "'.$session->getId().'",
		
	}, 
        //you need to put the session and the "format raw" in there, the other ones are what you would normally put in the url
	file_size_limit : "5 MB",
        //client side file chacking is for usability only, you need to check server side for security
	file_types : "*.*",
	file_types_description : "All Files",
	file_upload_limit : 100,
	file_queue_limit : 100,
	custom_settings : 
	{
		progressTarget : "fsUploadProgress",
		cancelButtonId : "btnCancel"
	},
	debug: false,
 
	// Button settings
	button_image_url: "'.$this->get('jsPath').'images/TestImageNoText_65x29.png",
	button_width: "85",
	button_height: "29",
	button_placeholder_id: "spanButtonPlaceHolder",
	button_text: \'<span class="theFont">Choose Files</span>\',
	button_text_style: ".theFont { font-size: 13; }",
	button_text_left_padding: 5,
	button_text_top_padding: 5,
 
	// The event handler functions are defined in handlers.js
	file_queued_handler : fileQueued,
	file_queue_error_handler : fileQueueError,
	file_dialog_complete_handler : fileDialogComplete,
	upload_start_handler : uploadStart,
	upload_progress_handler : uploadProgress,
	upload_error_handler : uploadError,
	upload_success_handler : uploadSuccess,
	upload_complete_handler : uploadComplete,
	queue_complete_handler : queueComplete	// Queue plugin event
};
swfu = new SWFUpload(settings);
};
 
';
 
$document =& JFactory::getDocument();
$document->addScriptDeclaration($swfUploadHeadJs);