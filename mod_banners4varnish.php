<?php
/**
 * @package     Alligo.Modules
 * @subpackage  mod_banners4varnish
 *
 * @copyright   Copyright (C) 2005 - 2015 Alligo Ltda. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

$headerText = trim($params->get('header_text'));
$footerText = trim($params->get('footer_text'));

require_once JPATH_ADMINISTRATOR . '/components/com_banners/helpers/banners.php';

if (class_exists('BannerHelper')) {
    // Only execute if already not loaded by native mod_banners
    BannerHelper::updateReset();
}

$list = &ModBanners4varnishHelper::getList($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_banners4varnish', $params->get('layout', 'default'));
