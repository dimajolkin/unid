<?php
/**
 * Created by PhpStorm.
 * User: Develop
 * Date: 28.11.2014
 * Time: 11:54
 */

namespace unid\Factory\Controller\NPR;


use unid\Controller\NPR\IndexController;
use Zend\EventManager\EventManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use unid\Controller\NPR\IndexController as IndexConroller;
use Zend\View\Model\ViewModel;

class IndexControllerFactory implements FactoryInterface {
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $controllerManager
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        // TODO: Implement createService() method.
        $serviceLocator = $controllerManager->getServiceLocator();

        $auth = $serviceLocator->get('zfcuser_auth_service');

        if ($auth->hasIdentity()) {

        }
        $user = $auth->getIdentity();

        $adapter = $serviceLocator->get('Adapter');


        $controller = new IndexController($user, $adapter);
        return $controller;
    }

} 