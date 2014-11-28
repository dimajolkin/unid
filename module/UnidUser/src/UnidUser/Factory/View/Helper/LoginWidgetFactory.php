<?php
namespace UnidUser\Factory\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\HelperPluginManager;
use UnidUser\Form;
use ZfcUser\Options;
use UnidUser\View\Helper\ZfcUserLoginWidget;

class LoginWidgetFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $pluginManager)
    {
        /* @var $pluginManager HelperPluginManager */
        $serviceManager = $pluginManager->getServiceLocator();

        /* @var $options Options\ModuleOptions */
        $options = $serviceManager->get('zfcuser_module_options');
        $unid_option = $serviceManager->get('uniduser_module_options');

        $viewTemplate = $options->getUserLoginWidgetViewTemplate();

        /* @var $loginForm Form\Login */

        $loginForm = $serviceManager->get('zfcuser_login_form');
        $loginKafedraForm = $serviceManager->get('zfcuser_login_kafedra_form');

       $login_redirect = $unid_option->getFormRedirect('login');
        $login_kafedra_redirect = $unid_option->getFormRedirect('kafedra');

        $viewHelper = new ZfcUserLoginWidget;
        $viewHelper
            ->setViewTemplate($viewTemplate)
            ->setLoginForm($loginForm)
            ->setLoginKafedraForm($loginKafedraForm)
            ->setKafedraRedirect($login_kafedra_redirect)
            ->setLoginRedirect($login_redirect)

        ;

        return $viewHelper;
    }
}
