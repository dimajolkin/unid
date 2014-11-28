<?php
namespace UnidUser\Factory\Controller\Plugin;

use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\PluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use UnidUser\Authentication\Adapter;
use UnidUser\Controller\Plugin\ZfcUserAuthentication;

class ZfcUserAuthenticationFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $pluginManager)
    {
        /* @var $pluginManager PluginManager */
        $serviceManager = $pluginManager->getServiceLocator();

        /* @var $authService AuthenticationService */
        $authService = $serviceManager->get('zfcuser_auth_service');

        /* @var $authAdapter Adapter\AdapterChain */

        $authAdapter = $serviceManager->get('UnidUser\Authentication\Adapter\AdapterChain');


        $controllerPlugin = new ZfcUserAuthentication;
        $controllerPlugin
            ->setAuthService($authService)
            ->setAuthAdapter($authAdapter)
        ;

        return $controllerPlugin;
    }
}
