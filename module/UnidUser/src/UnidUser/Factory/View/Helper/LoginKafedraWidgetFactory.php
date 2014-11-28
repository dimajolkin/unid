<?php
namespace UnidUser\Factory\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\HelperPluginManager;
use ZfcUser\Form;
use ZfcUser\Options;
use UnidUser\View\Helper\ZfcUserLoginKafedraWidget;

class LoginKafedraWidgetFactory implements FactoryInterface
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
        $viewTemplate = $options->getUserLoginWidgetViewTemplate();

        /* @var $loginForm Form\Login */
        $loginForm = $serviceManager->get('zfcuser_login_kafedra_form');


        $viewHelper = new ZfcUserLoginKafedraWidget();
        $viewHelper
            ->setViewTemplate($viewTemplate)
            ->setLoginForm($loginForm)
        ;

        return $viewHelper;
    }
}
