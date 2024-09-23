<?php
/**
****************************************************************************
**   @version    2.0.0                                                    **
**   @package    mod_tinyslider                                           **
**   @author     Manuel Häusler <tech.spuur@quickline.ch>                 **
**   @copyright  2024 Manuel Haeusler                                     **
**   @license    GNU General Public License version 3 or later            **
****************************************************************************/

namespace Elfangor93\Module\Tinyslider\Site\Helper;

\defined('_JEXEC') or die;

use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Uri\Uri;
use \Joomla\CMS\Language\Multilanguage;
use \Joomla\Registry\Registry;

/**
 * Helper class for mod_tinyslider
 *
 * @since  2.0.0
 */
class TinysliderHelper
{
  /**
   * Get a list of links from the endpoint given in the module params.
   *
   * @param   Registry   $params   Object holding the module parameters
   *
   * @return  array      List with image data
   *
   * @since   2.0.0
   */
  public static function getImages(Registry $params)
  {
    $img_folder = $params->get('img_folder', 'images/sampledata/cassiopeia');

    // Create image array
    $all_files = \glob(JPATH_BASE.'/'.$img_folder.'/*.*');
    $img_array = [];
    $num_files = \count($all_files);
    $base_folder = JPATH_BASE.'/';

    // Change image url to absolute url if multilanguage is enabled
    $root_url = '';
    if(Multilanguage::isEnabled())
    {
      $root_url = Uri::root();
    }

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
        $supported_format = ['jpg','jpeg','png'];

        // save file-extension in $ext
        $ext = \strtolower(\pathinfo($image_name, PATHINFO_EXTENSION));

        // check if file has a supportet format
        if (\in_array($ext, $supported_format))
        {
          // create image URL out of path
          $image_url = $root_url . \substr($image_name, \strlen($base_folder));

          // create image ALT out of actual image
          $image_alt = \substr(\substr($image_name, (\strpos($image_name, $img_folder) + \strlen($img_folder)) + 1), 0, -1 * (\strlen($ext) + 1));

          // get width and height of image
          list($width, $height, $type, $attr) = \getimagesize($image_name);
          $img = ['url' => $image_url, 'alt' => $image_alt, 'width' => $width, 'height' => $height];
          \array_push($img_array, $img);
        }
      }

      return $img_array;
    }
  }
}
