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
    protected function getLayoutData(): array
    {
        $data = parent::getLayoutData();
        $module = $data['module'];

        // Get images
        $data['img_array'] = $this->getHelperFactory()->getHelper('TinysliderHelper')->getImages($data['params']);

        // Random image pointer
        $data['rnd_ini'] = \count($data['img_array']) > 0 ? \rand(0, \count($data['img_array']) - 1) : null;
        $data['module_id'] = (int) $module->id;

        // Set and use assets
        /** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
        $wa = Factory::getApplication()->getDocument()->getWebAssetManager();
        $wa->getRegistry()->addRegistryFile('media/mod_tinyslider/joomla.asset.json');
        $wa->useStyle('mod_tinyslider.tiny-slider')
            ->useScript('mod_tinyslider.tiny-slider');
        $wa->addInlineStyle('.tns-outer {z-index: 1;}', ['position' => 'after']);

        return $data;
    }
}
