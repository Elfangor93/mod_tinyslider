<?php
/**
 * Tiny slider Module Entry Point
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

use \Joomla\CMS\Factory;
use \Joomla\CMS\Helper\ModuleHelper;
use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Language\Text;

// Pick out the input-fields of the backend
$img_folder       = $params->get('img_folder');
$slider_speed     = $params->get('speed', 1000);
$slider_timeout   = $params->get('timeout', 5000);
$slider_effect    = $params->get('effect', 'carousel');
$slider_lazyload  = $params->get('lazyload', 1);
$slider_arrowkeys = $params->get('arrowkeys', 1);
$slider_mousedrag = $params->get('mousedrag', 0);
$slider_autoplay  = $params->get('autoplay', 1);
$slider_vis_reset = $params->get('visibilityReset', 1);

// Set base path
$basePath = dirname(__FILE__);

// Create image array
$all_files = glob(JPATH_BASE.'/'.$img_folder.'/*.*');
$img_array = array();
$num_files = count($all_files);
$base_folder = JPATH_BASE.'/';

if ($num_files == 0)
{
  echo Text::_('MOD_TINYSLIDER_NOIMAGES');
}
else
{
  for ($i=0; $i < $num_files; $i++)
  {
    $image_name = $all_files[$i];
    // supported formats
    $supported_format = array('jpg','jpeg','png');
    // save file-extension in $ext
    $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    // check if file has a supportet format
    if (in_array($ext, $supported_format))
    {
      // create image URL out of path
      $image_url = substr($image_name, strlen($base_folder));
      // create image ALT out of actual image
      $image_alt = substr(substr($image_name, (strpos($image_name,$img_folder) + strlen($img_folder)) + 1), 0, -1 * (strlen($ext) + 1));
      // get width and height of image
      list($width, $height, $type, $attr) = getimagesize($image_name);
      $img = array('url' => $image_url, 'alt' => $image_alt, 'width' => $width, 'height' => $height);
      array_push($img_array, $img);
    }
  }

  // Random image pointer
  $rnd_ini = rand(0,(count($img_array)-1));

  // Set and use assets
  /** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
  $wa = Factory::getApplication()->getDocument()->getWebAssetManager();
  $wa->registerAndUseStyle('module.tinyslider', 'mod_tinyslider/tiny-slider.css');
  $wa->registerAndUseScript('module.tinyslider-helper', 'mod_tinyslider/tiny-slider.helper.ie8.js');

  require ModuleHelper::getLayoutPath('mod_tinyslider');
}
