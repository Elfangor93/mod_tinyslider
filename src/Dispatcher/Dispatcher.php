<?php
/**
****************************************************************************
**   @version    2.0.0                                                    **
**   @package    mod_tinyslider                                           **
**   @author     Manuel Häusler <tech.spuur@quickline.ch>                 **
**   @copyright  2024 Manuel Haeusler                                     **
**   @license    GNU General Public License version 3 or later            **
****************************************************************************/

namespace Elfangor93\Module\Tinyslider\Site\Dispatcher;

defined('_JEXEC') or die;

use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\HelperFactoryAwareInterface;
use Joomla\CMS\Helper\HelperFactoryAwareTrait;

/**
 * Dispatcher class for mod_tinyslider
 *
 * @since  2.0.0
 */
class Dispatcher extends AbstractModuleDispatcher implements HelperFactoryAwareInterface
{
    use HelperFactoryAwareTrait;

    /**
     * Returns the layout data.
     *
     * @return  array
     *
     * @since   2.0.0
     */
    protected function getLayoutData()
    {
        $data = parent::getLayoutData();

        // Get images
        $data['img_array'] = $this->getHelperFactory()->getHelper('TinysliderHelper')->getImages($data['params']);

        // Random image pointer
        $data['rnd_ini'] = \rand(0, (\count($data['img_array']) - 1));

        // Set and use assets
        /** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
        $wa = Factory::getApplication()->getDocument()->getWebAssetManager();
        $wa->registerAndUseStyle('mod_tinyslider', 'mod_tinyslider/tiny-slider.css');
        if($data['params']->get('compatibility', 0))
        {
            $wa->registerAndUseScript('mod_tinyslider-helper', 'mod_tinyslider/tiny-slider.helper.ie8.min.js');
        }
        $wa->registerAndUseScript('mod_tinyslider', 'mod_tinyslider/tiny-slider.min.js');
        $wa->addInlineStyle('.tns-outer {z-index: 1;}', ['position' => 'after']);

        return $data;
    }
}
