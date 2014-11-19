<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace unid;

use unid\Model\Autorization;
use unid\Model\Data;
use unid\Model\UserStorage;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\TableGateway\Feature;

use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;
use Zend\ModuleManager\ModuleManager;
use Zend\Db\Adapter\AdapterServiceFactory;


class Module
{

//    public function init(){
//        session_start();
//    }
    public function init(ModuleManager $manager)
    {

        $events = $manager->getEventManager();
        $sharedEvents = $events->getSharedManager();

        $sharedEvents->attach(__NAMESPACE__, 'dispatch', function($e) {
            $viewModel = $e->getViewModel();
            $Auth = new Autorization();
            // var_dump($Auth->get());

            if($Auth->is_vars())
            {
                $user =  $Auth->get();
                if( is_object($user) )
                {
                    $viewModel->setVariables(array(
                        'user'=> $user
                    ));
                }
            }
            $controller = $e->getTarget();
            // var_dump(get_class($controller));
            if (get_class($controller) == 'unid\Controller\UserController')         {

            }
            if (get_class($controller) == 'unid\Controller\ArchiveController')         {
                //     $controller->layout('layout/archive');

            }
            if (get_class($controller) == 'unid\Controller\AutorizationController'){
                $controller->layout('layout/autoriz');
            }
            if (get_class($controller) == 'unid\Controller\RegistrationController'){
                $controller->layout('layout/autoriz');
            }
        }, 100);


    }
    public function onBootstrap(MvcEvent $e)
    {

        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

    }


    public function getConfig()
    {

        return include __DIR__ . '/config/module.config.php';
    }


    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,

                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Storage' => function($sm){
                        $storage = new Model\UserStorage();
                        return $storage;
                    },

                'Auth' => function($sm){
                        $storage = new Model\Autorization();
                        return $storage;
                    },
                'User' => function($sm){
                        $storage = new Model\Autorization();
                        return $storage->get('user');

                    },

                'Adapter' =>  function($sm) {
                        return $sm->get('ZendDbAdapterAdapter');
                    },
                'unid.config'=> function($sm){
                        return include  __DIR__.'/config/unid.config.php';
                    }
//            ,
//                  'MyTwigFilesystemLoader' => function($sm) {
//                    return new \Twig_Loader_Filesystem('my/custom/twig/path');
//                }
            )
        );
    }
}
