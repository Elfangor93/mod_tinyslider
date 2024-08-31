<?php
/**
****************************************************************************
**   @version    1.1.0                                                    **
**   @package    mod_tinyslider                                           **
**   @author     Manuel Häusler <tech.spuur@quickline.ch>                 **
**   @copyright  2024 Manuel Haeusler                                     **
**   @license    GNU General Public License version 3 or later            **
****************************************************************************/

use Joomla\CMS\Application\AdministratorApplication;
use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Installer\InstallerScriptInterface;
use Joomla\CMS\Language\Text;
use Joomla\Database\DatabaseInterface;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
 
\defined('_JEXEC') or die;

return new class () implements ServiceProviderInterface
{
  public function register(Container $container)
  {
    $container->set(
        InstallerScriptInterface::class,
        new class($container->get(AdministratorApplication::class), $container->get(DatabaseInterface::class)) implements InstallerScriptInterface
      {
        private AdministratorApplication $app;
        private DatabaseInterface $db;

        private string $minimumJoomla = '4.0.0';
        private string $minimumPhp    = '7.4.0';
        private string $extension     = 'mod_tinyslider';

        public function __construct(AdministratorApplication $app, DatabaseInterface $db)
        {
          $this->app = $app;
          $this->db  = $db;
        }

        /**
         * Method to install the component
         *
         * @param   mixed $parent Object who called this method.
         *
         * @return  void
         */
        public function install(InstallerAdapter $parent): bool
        {
          echo $this->postInstallMessage(
                  Text::_('MOD_TINYSLIDER_INSTALL_TITLE'),
                  (string) $parent->getManifest()->version,
                  Text::_('MOD_TINYSLIDER_INSTALL_TEXT')
                );

          return true;
        }

        /**
         * Method to update the component
         *
         * @param   mixed $parent Object who called this method.
         *
         * @return  void
         */
        public function update(InstallerAdapter $parent): bool
        {
          echo $this->postInstallMessage(
                  Text::_('MOD_TINYSLIDER_UPDATE_TITLE'),
                  (string) $parent->getManifest()->version,
                  Text::_('MOD_TINYSLIDER_INSTALL_TEXT')
                );

          return true;
        }

        /**
         * Method to uninstall the component
         *
         * @param   mixed $parent Object who called this method.
         *
         * @return void
         */
        public function uninstall(InstallerAdapter $parent): bool
        {
          return true;
        }

        /**
         * Method called before install/update the component. Note: This method won't be called during uninstall process.
         *
         * @param   string   $type     Type of process [install | update | uninstall]
         * @param   mixed    $adapter  Installer class who called this method
         *
         * @return  boolean  True if the process should continue, false otherwise
         */
        public function preflight(string $type, InstallerAdapter $adapter): bool
        {      
          if (version_compare(PHP_VERSION, $this->minimumPhp, '<'))
          {
            $this->app->enqueueMessage(sprintf(Text::_('JLIB_INSTALLER_MINIMUM_PHP'), $this->minimumPhp), 'error');

            return false;
          }

          if (version_compare(JVERSION, $this->minimumJoomla, '<'))
          {
            $this->app->enqueueMessage(sprintf(Text::_('JLIB_INSTALLER_MINIMUM_JOOMLA'), $this->minimumJoomla), 'error');

            return false;
          }

          return true;
        }

        /**
         * Runs right after any installation action is performed on the component.
         *
         * @param   string   $type     Type of process [install | update | uninstall]
         * @param   mixed    $adapter  Installer class who called this method
         *
         * @return void
         */
        public function postflight(string $type, InstallerAdapter $parent): bool
        {
          return true;
        }

        /**
         * Returns the post-install message
         *
         * @param   string    $title          Title of the message
         * @param   string    $version        Version of the extension
         * @param   string    $install_msg    Post-install message
         *
         * @return  string    The message
         */
        private function postInstallMessage($title, $version = '', $install_msg = '')
        {
          $style = '<style>.img-wrapper a[target="_blank"]::before{content:""!important;padding:0!important;}.img-wrapper img{max-width:100%;max-height:250px;}.txt-wrapper{display:flex;flex-direction:column;justify-content:center;align-content:space-between;text-align:center;}.txt-wrapper>p{margin:0.7rem 0;}.txt-wrapper .alert{margin:1rem 0 0;}.alert.alert-info a:hover{color:var(--btn-hover-color);}</style>';

          $html  = '<div class="container alert alert-light">';
          $html .=    '<div class="row">';
          $html .=      '<div class="txt-wrapper col-9">';
          $html .=        '<h2 class="h1">' . $title . '</h2>';
          if(!empty($version))
          {
            $html .=      '<h3>' . Text::_('JVERSION') . ': ' . $version . '</h3>';
          }
          if(!empty($install_msg))
          {
            $html .=      '<p>' . $install_msg . '</p>';
          }
          $html .=        '<div class="alert alert-info">';
          $html .=          '<p>' . Text::_(strtoupper($this->extension).'_DONATE_TEXT') . '</p>';
          $html .=          '<a class="btn btn-outline-primary" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=C28HUM53S6EC2" target="_blank">' . Text::_(strtoupper($this->extension).'_DONATE') . '</a>';
          $html .=        '</div>';
          $html .=      '</div>';
          $html .=      '<div class="img-wrapper col-3 text-center">';
          $html .=          '<a href="https://tech.spuur.ch" target="_blank">';
          $html .=            '<img src="https://tech.spuur.ch/images/symbols/logo_cpl.png" alt="Logo Tech.Spuur">';
          $html .=          '</a>';
          $html .=      '</div>';
          $html .=    '</div>';
          $html .= '</div>';

          return trim($style.$html);
        }
      }
    );
  }
};
