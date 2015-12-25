<?php
defined('_JEXEC') or die;
//print_r($params);
//print_r($list);
$modules = JModuleHelper::getModuleList();
//echo '<pre>' ; var_dump($params); echo '</pre>';

//echo '<pre>' ; var_dump($params, htmlentities(json_encode($modules))); echo '</pre>';
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
                //var_dump($module_params->catid, $params->catid, $params['catid'], $module_params->ordering, $module_params->header_text, $params);die;
                $id_modulo = $module->id;
                break;
            }
            //var_dump($module);
            //var_dump($module_params->layout);
            //die;
        }
    }
}
//var_dump($module);
//die;
if (!empty($id_modulo)) :
?>
<div class="banner-ajax" id="banner-ajax<?= $id_modulo ?>"></div>
<script>
    // Carrega o banner entre 50 a 200ms
    setTimeout(function() {
        jQuery("#banner-ajax<?= $id_modulo ?>").load("<?= JUri::base(true) ?>/index.php?option=com_ajax&module=banners4varnish&format=raw&bannerid=<?= $id_modulo ?>&no_cache=" + (new Date().getTime()));
    }, (Math.floor(Math.random() * (200 - 50)) + 50));
    //}, 500 + (Math.floor(Math.random() * (600 - 100)) + 100));
</script>
<?php else: ?>
<!-- Houve algum erro, e este banner não pôde ser carregado -->
<?php endif; ?>

<?php
// Load library
if (!empty($gaetclickcat) || !empty($gaetviews)) {

    // Load jQuery
    JHtml::_('jquery.framework');
    $document = JFactory::getDocument();
    $document->addScript(JUri::base(true) . '/media/alligo/js/gaet.min.js');
}
?>
