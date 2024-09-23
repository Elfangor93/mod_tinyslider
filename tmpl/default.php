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
?>

<div class="tinyslider">
  <?php foreach ($img_array as $key => $img) : ?>
    <div>
      <img id="sliderIMG-<?php echo $key; ?>" class="slideshow-img<?php if($params->get('lazyload', 1)){echo ' tns-lazy-img';}?>" <?php if($params->get('lazyload', 1)){echo 'data-';}?>src="<?php echo $img['url'];?>" alt="<?php echo $img['alt'];?>" width="<?php echo $img['width'];?>" height="<?php echo $img['height'];?>"/>
    </div>
  <?php endforeach; ?>
</div>

<script>
  let options = {
    container: '.tinyslider',
    mode: '<?php echo $params->get('effect', 'carousel');?>',
    lazyload: <?php if($params->get('lazyload', 1)){echo 'true';} else {echo 'false';}; ?>,
    arrowKeys: <?php if($params->get('arrowkeys', 1)){echo 'true';} else {echo 'false';}; ?>,
    mouseDrag: <?php if($params->get('mousedrag', 0)){echo 'true';} else {echo 'false';}; ?>,
    speed: <?php echo intval($params->get('speed', 1000)); ?>,
    autoplay: <?php if($params->get('autoplay', 1)){echo 'true';} else {echo 'false';}; ?>,
    autoplayTimeout: <?php echo intval($params->get('timeout', 5000)); ?>,
    autoplayButtonOutput: false,
    autoplayResetOnVisibility: <?php if($params->get('visibilityReset', 1)){echo 'true';} else {echo 'false';}; ?>,
    autoplayHoverPause: <?php if($params->get('hoverPause', 0)){echo 'true';} else {echo 'false';}; ?>,
    controls: false,
    nav: false,
    center: true
  }

  let slider = tns(options);
</script>
