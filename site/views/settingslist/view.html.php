<?php
/**
* @version		$Id: default_viewlist.php 96 2011-08-11 06:59:32Z michel $
* @package		Convertbapliemovins
* @subpackage 	Views
* @copyright	Copyright (C) 2012, . All rights reserved.
* @license #
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

 
class ConvertbapliemovinsViewSettingslist  extends JView 
{
	public function display($tpl = null)
	{
		
		$app = &JFactory::getApplication('site');
		$document	= &JFactory::getDocument();
		$uri 		= &JFactory::getURI();
		$user 		= &JFactory::getUser();
		$pagination	= &$this->get('pagination');
		$params		= $app ->getParams();				
		$menus	= &JSite::getMenu();
		
		$menu	= $menus->getActive();
		if (is_object( $menu )) {
			$menu_params = $menus->getParams($menu->id) ;
			if (!$menu_params->get( 'page_title')) {
				$params->set('page_title', 'Convert Baplie to Movins');
			}
		}		
				
//		$items = $this->get( 'Items' );
//		$this->assignRef( 'items', $items);

		$this->assignRef('params', $params);
//		$this->assignRef('pagination', $pagination);
		parent::display($tpl);
	}
}
?>