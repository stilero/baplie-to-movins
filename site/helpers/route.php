<?php
/**
 * @version		$Id: route.php 96 2011-08-11 06:59:32Z michel $
 * @package		Convertbapliemovins
 * @subpackage	Helpers
 * @copyright	Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

// Component Helper
jimport('joomla.application.component.helper');
global $alt_libdir;
JLoader::import('joomla.application.categories', $alt_libdir);
/**
 * Convertbapliemovins Component Route Helper
 *
 * @static
 * @package		Convertbapliemovins
 * @subpackage	Helpers

 */
abstract class ConvertbapliemovinsHelperRoute
{
	protected static $lookup;
	/**
	 * @param	int	The route of the convertbapliemovins
	 */
	public static function getConvertbapliemovinsRoute($id, $catid)
	{
		$needles = array(
			'settings'  => array((int) $id)
		);
		//Create the link
		$link = 'index.php?option=com_convertbapliemovins&view=settings&id='. $id;
		if ($catid > 1) {
			$categories = JCategories::getInstance('Settings');
			$category = $categories->get($catid);
			if ($category) {
				$needles['category'] = array_reverse($category->getPath());
				$needles['categories'] = $needles['category'];
				$link .= '&catid='.$catid;
			}
		}

		if ($item = ConvertbapliemovinsHelperRoute::_findItem($needles)) {
			$link .= '&Itemid='.$item;
		};

		return $link;
	}


	public static function getCategoryRoute($catid)
	{
		$app = JFactory::getApplication();
	    if ($catid instanceof JCategoryNode)
		{
			$id = $catid->id;
			$category = $catid;
		}
		else
		{
			$id = (int) $catid;
		    $options['extension'] = $app->getUserStateFromRequest('filter.extension', 'extension', 'com_convertbapliemovins.settings');	
			$options['table'] = $app->getUserStateFromRequest('filter.extensiontable', 'extensiontable');
			$category = BookshopCategories::getInstance('Convertbapliemovins',$options)->get($id);
		}

		if($id < 1)
		{
			$link = '';
		}
		else
		{
			$needles = array(
				'category' => array($id)
			);

			if ($item = self::_findItem($needles))
			{
				$link = 'index.php?Itemid='.$item;
			}
			else
			{
				//Create the link
				$link = 'index.php?option=com_convertbapliemovins&view=category&id='.$id;
				if($category)
				{
					$catids = array_reverse($category->getPath());
					$needles = array(
						'category' => $catids,
						'categories' => $catids
					);
					if ($item = self::_findItem($needles)) {
						$link .= '&Itemid='.$item;
					}
					elseif ($item = self::_findItem()) {
						$link .= '&Itemid='.$item;
					}
				}
			}
		}

		return $link;
	}
	
	protected static function _findItem($needles)
	{
		// Prepare the reverse lookup array.
		if (self::$lookup === null) {
			self::$lookup = array();

			$component	= JComponentHelper::getComponent('com_convertbapliemovins');
			$menus		= JApplication::getMenu('site');
			$jv = new JVersion();
			$field = ($jv->RELEASE < 1.6) ? 'componentid' : 'component_id';
			$items		= $menus->getItems($field, $component->id);
			foreach ($items as $item) {
				if (isset($item->query) && isset($item->query['view'])) {
					$view = $item->query['view'];
					if (!isset(self::$lookup[$view])) {
						self::$lookup[$view] = array();
					}
					if (isset($item->query['id'])) {
						self::$lookup[$view][$item->query['id']] = $item->id;
					}
				}
			}
		}
		foreach ($needles as $view => $ids) {
			if (isset(self::$lookup[$view])) {
				
				foreach ($ids as $id) {
					if (isset(self::$lookup[$view][(int)$id])) {
						return self::$lookup[$view][(int)$id];
					}
				}
			}
		}

		return null;
	}
}
