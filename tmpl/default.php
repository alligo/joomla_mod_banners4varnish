<?php
/**
 * File based on native Joomla mod_banners from Joomla 3.4.6
 *
 * @package     Joomla.Site
 * @subpackage  mod_banners
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once JPATH_ROOT . '/components/com_banners/helpers/banner.php';
$baseurl = JUri::base();
?>
<div class="bannergroup<?php echo $moduleclass_sfx ?>">
<?php if ($headerText) : ?>
	<?php echo $headerText; ?>
<?php endif; ?>

<?php foreach ($list as $item) : ?>
    <?php
    // Alligo
    if (!empty($gaetclickcat)) {
        $gaet_data_attrs = ' data-ga-event="click"';
        $gaet_data_attrs .= 'data-ga-category="' . (!empty($gaetclickcat) ? $gaetclickcat : "ModBanner4varnish/UndefinedCategory") . '"';
        $gaet_data_attrs .= 'data-ga-action="'. (!empty($gaetclickaction) ? $gaetclickaction : "ModBanner4varnish/Click/UndefinedAction") .'"';
        $gaet_data_attrs .= 'data-ga-label="' . (!empty($gaetclicklabel) ? $gaetclicklabel : ("ID:" . $item->id . ",CID:" . $item->cid
    . ",Name:" . JFilterOutput::stringURLSafe($item->name) )) . '" ';
        if (false) {
           $gaet_data_attrs .=  'data-ga-value="' . $gaetclickvalue .'" ';
        }
    } else {
        $gaet_data_attrs = '';
    }


    ?>
	<div class="banneritem">
		<?php $link = JRoute::_('index.php?option=com_banners&task=click&id=' . $item->id);?>
		<?php if ($item->type == 1) :?>
			<?php // Text based banners ?>
			<?php echo str_replace(array('{CLICKURL}', '{NAME}'), array($link, $item->name), $item->custombannercode);?>
		<?php else:?>
			<?php $imageurl = $item->params->get('imageurl');?>
			<?php $width = $item->params->get('width');?>
			<?php $height = $item->params->get('height');?>
			<?php if (BannerHelper::isImage($imageurl)) :?>
				<?php // Image based banner ?>
				<?php $alt = $item->params->get('alt');?>
				<?php $alt = $alt ? $alt : $item->name; ?>
				<?php $alt = $alt ? $alt : JText::_('MOD_BANNERS_BANNER'); ?>
				<?php if ($item->clickurl) :?>
					<?php // Wrap the banner in a link?>
					<?php $target = $params->get('target', 1);?>
					<?php if ($target == 1) :?>
						<?php // Open in a new window?>
						<a
                            <?= $gaet_data_attrs ?>
							href="<?php echo $link; ?>" target="_blank"
							title="<?php echo htmlspecialchars($item->name, ENT_QUOTES, 'UTF-8');?>">
							<img
								src="<?php echo $baseurl . $imageurl;?>"
								alt="<?php echo $alt;?>"
								<?php if (!empty($width)) echo 'width ="' . $width . '"';?>
								<?php if (!empty($height)) echo 'height ="' . $height . '"';?>
							/>
						</a>
					<?php elseif ($target == 2):?>
						<?php // Open in a popup window?>
						<a
                            <?= $gaet_data_attrs ?>
							href="<?php echo $link;?>" onclick="window.open(this.href, '',
								'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550');
								return false"
							title="<?php echo htmlspecialchars($item->name, ENT_QUOTES, 'UTF-8');?>">
							<img
								src="<?php echo $baseurl . $imageurl;?>"
								alt="<?php echo $alt;?>"
								<?php if (!empty($width)) echo 'width ="' . $width . '"';?>
								<?php if (!empty($height)) echo 'height ="' . $height . '"';?>
							/>
						</a>
					<?php else :?>
						<?php // Open in parent window?>
						<a
                            <?= $gaet_data_attrs ?>
							href="<?php echo $link;?>"
							title="<?php echo htmlspecialchars($item->name, ENT_QUOTES, 'UTF-8');?>">
							<img
								src="<?php echo $baseurl . $imageurl;?>"
								alt="<?php echo $alt;?>"
								<?php if (!empty($width)) echo 'width ="' . $width . '"';?>
								<?php if (!empty($height)) echo 'height ="' . $height . '"';?>
							/>
						</a>
					<?php endif;?>
				<?php else :?>
					<?php // Just display the image if no link specified?>
					<img
						src="<?php echo $baseurl . $imageurl;?>"
						alt="<?php echo $alt;?>"
						<?php if (!empty($width)) echo 'width ="' . $width . '"';?>
						<?php if (!empty($height)) echo 'height ="' . $height . '"';?>
					/>
				<?php endif;?>
			<?php elseif (BannerHelper::isFlash($imageurl)) :?>
				<object
					classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
					codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
					<?php if (!empty($width)) echo 'width ="' . $width . '"';?>
					<?php if (!empty($height)) echo 'height ="' . $height . '"';?>
				>
					<param name="movie" value="<?php echo $imageurl;?>" />
					<embed
						src="<?php echo $imageurl;?>"
						loop="false"
						pluginspage="http://www.macromedia.com/go/get/flashplayer"
						type="application/x-shockwave-flash"
						<?php if (!empty($width)) echo 'width ="' . $width . '"';?>
						<?php if (!empty($height)) echo 'height ="' . $height . '"';?>
					/>
				</object>
			<?php endif;?>
		<?php endif;?>
		<div class="clr"></div>
	</div>
<?php endforeach; ?>

<?php if ($footerText) : ?>
	<div class="bannerfooter">
		<?php echo $footerText; ?>
	</div>
<?php endif; ?>
</div>
<?php //var_dump($item); ?>
<?php if (!empty($gaetviews) && !empty($item)) : ?>
<div
    data-ga-event="ready"
    data-ga-category="<?= !empty($gaetviewcat) ? $gaetviewcat : "ModBanner4varnish/UndefinedCategory"; ?>"
    data-ga-action="<?= !empty($gaetviewaction) ? $gaetviewaction : "ModBanner4varnish/Exibition/UndefinedAction";  ?>"
    data-ga-label="<?= !empty($gaetviewlabel) ? $gaetviewlabel : ("ID:" . $item->id . ",CID:" . $item->cid
    . ",Name:" . JFilterOutput::stringURLSafe($item->name) ); ?>">
</div>
<?php endif; ?>
<?php
// Load library
if (!empty($gaetclickcat) || !empty($gaetviews)):

    // Load jQuery
    //JHtml::_('jquery.framework');
    //$document = JFactory::getDocument();
    //$document->addScript('/media/alligo/js/gaet.min.js');

?>
<script>
    if (GAET) {
        GAET.initAll();
    } else {
        console.log('mod_banners4varnish ERROR! GAET not loaded');
    }
</script>
<?php endif; ?>