<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace UnidUser;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Application\Model\Data;
use Zend\ModuleManager\ModuleManager;
use Zend\ServiceManager\ServiceManager;

use Application\Form\LoginModificator;

class Module
{
    public function init(ModuleManager $manager)
    {
      //  $manager->loadModule('ZfcUser');

        $events = $manager->getEventManager();


        $sharedEvents = $events->getSharedManager();
        $sharedEvents->attach(__NAMESPACE__, 'dispatch', function($e) {
            $viewModel = $e->getViewModel();

        }, 100);

    }
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();

      //  $eventManager->trigger('ConfigUnidUser');

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



}
