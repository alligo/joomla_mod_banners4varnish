<?php
/**
 * @package     Alligo.Modules
 * @subpackage  mod_banners4varnish
 *
 * @copyright   Copyright (C) 2005 - 2015 Alligo Ltda. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Helper for mod_banners4varnish
 *
 * @package     Alligo.Modules
 * @subpackage  mod_banners4varnish
 * @since       3.4
 */
class ModBanners4varnishHelper
{

    /**
     * Retrieve list of banners
     *
     * @param   \Joomla\Registry\Registry  &$params  module parameters
     *
     * @return  mixed
     */
    public static function &getList(&$params)
    {
        JModelLegacy::addIncludePath(JPATH_ROOT . '/components/com_banners/models', 'BannersModel');
        $document = JFactory::getDocument();
        $app = JFactory::getApplication();
        $keywords = explode(',', $document->getMetaData('keywords'));

        $model = JModelLegacy::getInstance('Banners', 'BannersModel', array('ignore_request' => true));
        $model->setState('filter.client_id', (int) $params->get('cid'));
        $model->setState('filter.category_id', $params->get('catid', array()));
        $model->setState('list.limit', (int) $params->get('count', 1));
        $model->setState('list.start', 0);
        $model->setState('filter.ordering', $params->get('ordering'));
        $model->setState('filter.tag_search', $params->get('tag_search'));
        $model->setState('filter.keywords', $keywords);
        $model->setState('filter.language', $app->getLanguageFilter());

        $banners = $model->getItems();
        $model->impress();

        return $banners;
    }

    /**
     * Retorna HTML do modulo via requisição AJAX. Exemplo de URL:
     *
     * /?option=com_ajax&module=banners&format=raw&bannerid=189&no_cache=1450513754247
     *
     * @author  Emerson Rocha Luiz <emerson@alligo.com.br>
     *
     * return String
     */
    public static function getAjax()
    {
        //$modules = JModuleHelper::getModuleList();
        $banner_id = JFactory::getApplication()->input->getInt('bannerid', null);

//        $modules = JModuleHelper::getModuleList();
//        if (!empty($modules) && is_array($modules)) {
//            foreach ($modules AS $module) {
//                if ((int) $module->id === $banner_id) {
//                    $modulo_agora = $module;
//                    break;
//                }
//            }
//        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
            ->select('m.title')
            ->from('#__modules AS m')
            ->where('m.published = 1 and m.id = ' . (int) $banner_id)
            ;
        $db->setQuery($query);
        $modulo_agora_title = $db->loadResult();

        //var_dump($banner_id, $modulo_agora, $modules);

        if ($modulo_agora_title) {
            $module = JModuleHelper::getModule('banners4varnish', $modulo_agora_title);
            //var_dump($module, $modulo_agora_title);
            if (!empty($module)) {
                $registry = new JRegistry;
                $params = $registry->loadString($module->params);
                $list = self::getList($params);
                $headerText = trim($params->get('header_text'));
                $footerText = trim($params->get('footer_text'));
                $gaetclick = trim($params->get('gaetclick'));
                $gaetclickcat = trim($params->get('gaetclickcat'));
                $gaetclickaction = trim($params->get('gaetclickaction'));
                $gaetclicklabel = trim($params->get('gaetclicklabel'));
                $gaetclicklabel = trim($params->get('gaetclicklabel'));
                $gaetclickvalue = trim($params->get('gaetclickvalue'));
                $gaetviews = trim($params->get('gaetviews'));
                $gaetviewcat = trim($params->get('gaetviewcat'));
                $gaetviewaction = trim($params->get('gaetviewaction'));
                $gaetviewlabel = trim($params->get('gaetviewlabel'));
                $gaetviewvalue = trim($params->get('gaetviewvalue'));
                $moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

                require JModuleHelper::getLayoutPath('mod_banners4varnish', 'default');
            } else {
                return '<!-- mod_banners4varnish getAjax: error to load banner by title -->';
            }

        } else {
            return '<!-- mod_banners4varnish getAjax: error to find banner by id -->';
        }
    }
}
