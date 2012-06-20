<?php
/**
 * @version 1.0
 * @package    joomla
 * @subpackage Convertbapliemovins
 * @author	   	Daniel Eliasson Stilero Webdesign
 *  @copyright  	Copyright (C) 2012, Daniel Eliasson Stilero Webdesign. All rights reserved.
 *  @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

//--No direct access
defined('_JEXEC') or die('Resrtricted Access');
// Require the base controller
require_once( JPATH_COMPONENT.DS.'controller.php' );

jimport('joomla.application.component.model');
require_once( JPATH_COMPONENT.DS.'models'.DS.'model.php' );
// Component Helper
jimport('joomla.application.component.helper');

//add Helperpath to JHTML
JHTML::addIncludePath(JPATH_COMPONENT.DS.'helpers');

//include Helper
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'convertbapliemovins.php');

//Use the JForms, even in Joomla 1.5 
$jv = new JVersion();
$GLOBALS['alt_libdir'] = ($jv->RELEASE < 1.6) ? JPATH_COMPONENT_ADMINISTRATOR : null;

//set the default view
$controller = JRequest::getWord('view', 'settings');

//add submenu for 1.6
if ($jv->RELEASE > 1.5) {
	ConvertbapliemovinsHelper::addSubmenu($controller);	
}



$ControllerConfig = array();

// Require specific controller if requested
if ( $controller) {   
   $path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
   $ControllerConfig = array('viewname'=>strtolower($controller),'mainmodel'=>strtolower($controller),'itemname'=>ucfirst(strtolower($controller)));
   if ( file_exists($path)) {
       require_once $path;
   } else {       
	   $controller = '';	   
   }
}

// Create the controller
$classname    = 'ConvertbapliemovinsController'.$controller;
$controller   = new $classname($ControllerConfig );

// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );

// Redirect if set by the controller
$controller->redirect();