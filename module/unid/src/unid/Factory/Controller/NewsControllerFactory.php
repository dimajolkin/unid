<?php
/**
 * Created by PhpStorm.
 * User: Develop
 * Date: 28.11.2014
 * Time: 14:16
 */

namespace unid\Factory\Controller;


use unid\Controller\NewsController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class NewsControllerFactory implements FactoryInterface {
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

        $controller  = new NewsController($user, $adapter);

        return $controller;
    }


} 