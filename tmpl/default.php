<?php
/**
****************************************************************************
**   @version    2.0.0                                                    **
**   @package    mod_tinyslider                                           **
**   @author     Manuel Häusler <tech.spuur@quickline.ch>                 **
**   @copyright  2024 Manuel Haeusler                                     **
**   @license    GNU General Public License version 3 or later            **
****************************************************************************/

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

$sliderId = 'tinyslider' . (int) $module_id;
$lazyload = (bool) $params->get('lazyload', 1);
$effect = (string) $params->get('effect', 'carousel');
$effect = \in_array($effect, ['carousel', 'gallery'], true) ? $effect : 'carousel';

$options = [
  'container' => '#' . $sliderId,
  'mode' => $effect,
  'lazyload' => $lazyload,
  'arrowKeys' => (bool) $params->get('arrowkeys', 1),
  'mouseDrag' => (bool) $params->get('mousedrag', 0),
  'speed' => (int) $params->get('speed', 1000),
  'autoplay' => (bool) $params->get('autoplay', 1),
  'autoplayTimeout' => (int) $params->get('timeout', 5000),
  'autoplayButtonOutput' => false,
  'autoplayResetOnVisibility' => (bool) $params->get('visibilityReset', 1),
  'autoplayHoverPause' => (bool) $params->get('hoverPause', 0),
  'controls' => false,
  'nav' => false,
  'center' => true,
];

if ($rnd_ini !== null) {
  $options['startIndex'] = (int) $rnd_ini;
}

$jsonOptions = \json_encode($options, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
?>

<?php if (empty($img_array)) : ?>
  <p class="mod-tinyslider__empty"><?php echo Text::_('MOD_TINYSLIDER_NOIMAGES'); ?></p>
<?php else : ?>
<div id="<?php echo htmlspecialchars($sliderId, ENT_COMPAT, 'UTF-8'); ?>" class="tinyslider">
  <?php foreach ($img_array as $key => $img) : ?>
    <div>
      <img id="sliderIMG-<?php echo (int) $module_id; ?>-<?php echo (int) $key; ?>" class="slideshow-img<?php if ($lazyload) { echo ' tns-lazy-img'; } ?>" <?php if ($lazyload) { echo 'data-'; } ?>src="<?php echo htmlspecialchars($img['url'], ENT_COMPAT, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($img['alt'], ENT_COMPAT, 'UTF-8'); ?>" width="<?php echo (int) $img['width']; ?>" height="<?php echo (int) $img['height']; ?>"/>
    </div>
  <?php endforeach; ?>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    if (typeof tns === 'function') {
      tns(<?php echo $jsonOptions; ?>);
    }
  });
</script>
<?php endif; ?>
