<?php
/**
 * @package     Alligo.Modules
 * @subpackage  mod_banners4varnish
 *
 * @copyright   Copyright (C) 2005 - 2015 Alligo Ltda. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$modules = JModuleHelper::getModuleList();

$id_modulo = null;
foreach ($modules AS $module) {
    if ($module->module === 'mod_banners4varnish') {
        if ($module->params) {
            $registry = new JRegistry;
            $module_params = $registry->loadString($module->params);

            // Esse modulo não recebe ID de uma forma amigável. Infelismente, é necessário
            // descobrir por força quase bruta
            if ($module_params['catid'] === $params['catid'] &&
                $module_params['ordering'] === $params['ordering'] &&
                $module_params['header_text'] === $params['header_text'] &&
                $module_params['footer_text'] === $params['footer_text'] &&
                $module_params['moduleclass_sfx'] === $params['moduleclass_sfx']
            ) {
                $id_modulo = $module->id;
                break;
            }
        }
    }
}

if (!empty($id_modulo)) :
?>
<div class="banner-ajax" id="banner-ajax<?= $id_modulo ?>"></div>
<script>
    // Delay loading from 50ms to 200ms, to avoid a bit of overload the server
    setTimeout(function() {
        jQuery("#banner-ajax<?= $id_modulo ?>").load("<?= JUri::base(true) ?>/index.php?option=com_ajax&module=banners4varnish&format=raw&bannerid=<?= $id_modulo ?>&Itemid=<?= JFactory::getApplication()->input->getInt('Itemid', 0) ?>&id=<?= JFactory::getApplication()->input->getInt('id', 0) ?>&no_cache=" + (new Date().getTime()));
    }, (Math.floor(Math.random() * (200 - 50)) + 50));
</script>
<?php else: ?>
<!-- Houve algum erro, e este banner não pôde ser carregado -->
<?php endif; ?>

<?php
// Load library
if (!empty($gaetclickcat) || !empty($gaetviews)) {

    // Load jQuery
    JHtml::_('jquery.framework');

    // Protip: You can override this file, placing a copy on /templates/yourtemplate/js/alligo/gaet.min.js
    JHtml::script('alligo/gaet.min.js', false, true, false);
}
?>
