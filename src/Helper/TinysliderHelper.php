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
  public static function getImages(Registry $params): array
  {
    $img_folder = \trim(\str_replace('\\', '/', (string) $params->get('img_folder', 'images/sampledata/cassiopeia')), '/');
    $img_array = [];

    if ($img_folder === '' || \preg_match('#(^|/)\.\.(/|$)|^[a-z]:|^/#i', $img_folder)) {
      return $img_array;
    }

    $base_folder = \rtrim(JPATH_ROOT, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    $folder_path = \realpath($base_folder . \str_replace('/', DIRECTORY_SEPARATOR, $img_folder));

    if ($folder_path === false || !\is_dir($folder_path) || !\str_starts_with($folder_path . DIRECTORY_SEPARATOR, $base_folder)) {
      return $img_array;
    }

    $all_files = \glob($folder_path . DIRECTORY_SEPARATOR . '*.*') ?: [];

    // Change image url to absolute url if multilanguage is enabled
    $root_url = '';
    if(Multilanguage::isEnabled())
    {
      $root_url = Uri::root();
    }

    foreach ($all_files as $image_name)
    {
      if (!\is_file($image_name)) {
        continue;
      }

      // supported formats
      $supported_format = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];

      // save file-extension in $ext
      $ext = \strtolower(\pathinfo($image_name, PATHINFO_EXTENSION));

      // check if file has a supported format
      if (!\in_array($ext, $supported_format, true)) {
        continue;
      }

      $image_size = \getimagesize($image_name);

      if ($image_size === false) {
        continue;
      }

      $relative_path = \str_replace(DIRECTORY_SEPARATOR, '/', \substr($image_name, \strlen($base_folder)));
      $image_url = $root_url . $relative_path;
      $image_alt = \pathinfo($image_name, PATHINFO_FILENAME);

      $img_array[] = [
        'url' => $image_url,
        'alt' => $image_alt,
        'width' => (int) $image_size[0],
        'height' => (int) $image_size[1],
      ];
    }

    return $img_array;
  }
}
