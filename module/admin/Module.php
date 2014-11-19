<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace admin;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;

use unid\Model\Autorization;

class Module
{


    public function onBootstrap(MvcEvent $e)
    {

        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $app = $e->getParam('application');
        $app->getEventManager()->attach('dispatch', array($this, 'setLayout'), -100);

    }
    public function setLayout($e)
    {
        $matches    = $e->getRouteMatch();
        $controller = $matches->getParam('controller');
        if (!substr_count($controller, __NAMESPACE__, 0)) {
            // not a controller from this module
            return;
        }
        $viewModel = $e->getViewModel();
        if($controller == 'admin\Controller\Autorization')
        {
            $viewModel->setTemplate('layout/empty.phtml');
        }
        else {

            $Auth = new Autorization();
            if($Auth->is_vars())
            {
                $user =  $Auth->get();
                if(is_object($user))
                {
                    $viewModel->setVariable('user',$user);
                    $viewModel->setTemplate('layout/admin_layout.phtml');
                }
            }


        }

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

                'Adapter' =>  function($sm) {
                        return $sm->get('ZendDbAdapterAdapter');
                    },
            ),
        );
    }
}
