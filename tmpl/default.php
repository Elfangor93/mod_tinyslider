<?php
/**
 * VIEW of the tiny slider module
 * 
 * @package    Tinyslider
 * @subpackage mod_tinyslider
 * @version    1.0.0
 *
 * @author     Manuel Haeusler <tech.spuur@quickline.com>
 * @copyright  2022 Manuel Haeusler
 * @license    GNU/GPL, see LICENSE.php
 *
 * mod_tinyslider is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// No direct access
defined('_JEXEC') or die; 

use \Joomla\CMS\Uri\Uri;
?>

<div class="tinyslider">
  <?php foreach ($img_array as $key => $img) : ?>
    <div>
      <img id="sliderIMG-<?php echo $key; ?>" class="slideshow-img<?php if($slider_lazyload){echo ' tns-lazy-img';}?>" <?php if($slider_lazyload){echo 'data-';}?>src="<?php echo $img['url'];?>" alt="<?php echo $img['alt'];?>" width="<?php echo $img['width'];?>" height="<?php echo $img['height'];?>"/>
    </div>
  <?php endforeach; ?>
</div>

<script src="<?php echo Uri::base(true).'/media/mod_tinyslider/js/tiny-slider.min.js'; ?>"></script>

<script>
  let options = {
    container: '.tinyslider',
    mode: '<?php echo $slider_effect;?>',
    lazyload: <?php if($slider_lazyload){echo 'true';} else {echo 'false';}; ?>,
    arrowKeys: <?php if($slider_arrowkeys){echo 'true';} else {echo 'false';}; ?>,
    mouseDrag: <?php if($slider_mousedrag){echo 'true';} else {echo 'false';}; ?>,
    speed: <?php echo intval($slider_speed); ?>,
    autoplay: <?php if($slider_autoplay){echo 'true';} else {echo 'false';}; ?>,
    autoplayTimeout: <?php echo intval($slider_timeout); ?>,
    autoplayButtonOutput: false,
    autoplayResetOnVisibility: <?php if($slider_vis_reset){echo 'true';} else {echo 'false';}; ?>,
    controls: false,
    nav: false,
  }

  let slider = tns(options);
</script>
