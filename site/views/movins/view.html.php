<?php
/**
* @version		$Id: default_viewfrontend.php 96 2011-08-11 06:59:32Z michel $
* @package		Convertbapliemovins
* @subpackage 	Views
* @copyright	Copyright (C) 2012, Daniel Eliasson Stilero Webdesign. All rights reserved.
* @license #http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
jimport('joomla.filesystem.file');
 
class ConvertbapliemovinsViewMovins  extends JView 
{
    private $srcFile;
    
	public function display($tpl = null)
	{   
		$app = &JFactory::getApplication('site');
		$document	= &JFactory::getDocument();
		$uri 		= &JFactory::getURI();
		$user 		= &JFactory::getUser();
		//$pagination	= &$this->get('pagination');
		$params		= $app ->getParams();				
		$menus	= &JSite::getMenu();
		
		$menu	= $menus->getActive();
		if (is_object( $menu )) {
			$menu_params = $menus->getParams($menu->id) ;
			if (!$menu_params->get( 'page_title')) {
				$params->set('page_title', 'Settings');
			}
		}		


		//$item = $this->get( 'Item' );
		//$this->assignRef( 'item', $item );

		$this->assignRef('params', $params);
                
                $fileID = JRequest::getString('token');
                $fileName = $fileID.'.edi';
                $this->srcFile = JPATH_COMPONENT . DS . "uploads" . DS . $fileName;
                if(!JFile::exists($this->srcFile)){
                    $app->enqueueMessage(JText::_('File not found'));
                    $tpl = 'error';
                    $this->assignRef('file', $srcFile);
                    parent::display($tpl);
                    return;
                }  else {
                    $this->handleBaplie();
                }
		
		parent::display($tpl);
	}
        
        private function handleBaplie(){
            $classPath = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_convertbapliemovins'.DS.'classes'.DS.'edi'.DS;
            JLoader::register('EdiBaplie', $classPath.'edibaplie.php');
            JLoader::register('EdiMessage', $classPath.'edimessage.php');
            foreach (glob($classPath."edielements".DS."*.php") as $filename){
                require_once $filename;
            }
            $portOfLoading = JRequest::getWord('pol');
            $ediData = file_get_contents($this->srcFile);
            $baplie = new EdiBaplie($ediData);
            if(!$baplie->inPortsOfLoading($portOfLoading)){
                $app->enqueueMessage(JText::_('Port doesnt exist'), 'error');
                $url = 'index.php?option='.JRequest::getVar('option').'&view=settingslist';
                $app->redirect($url, JText::_('Port doesn\'t exist'), 'error');
            }
            $movinsData = $baplie->convertToMovins($portOfLoading, 'LOA', 'BERTHTOOLS');
            JFile::delete($this->srcFile);
            $this->assignRef('ediData', $movinsData);
            $this->assignRef('pol', $portOfLoading);
            parent::display('edi');
            return;
        }
}
?>