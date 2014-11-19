<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin',
                    'defaults' => array(
                        'controller' => 'admin\Controller\Autorization',
                        'action'     => 'index',
                    ),
                ),
            ),
            'interface' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/interface[/:action]',
                    'defaults' => array(
                        'controller' => 'admin\Controller\Interface',
                        'action'     => 'personal',
                    ),
                ),
            ),
            'constructor' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/constructor[/:action][/:id]',
                    'defaults' => array(
                        'controller' => 'admin\Controller\Constructor',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'admin\Controller\Autorization' => 'admin\Controller\AutorizationController',
            'admin\Controller\Interface' => 'admin\Controller\InterfaceController',
            'admin\Controller\Constructor' => 'admin\Controller\ConstructorController'


        ),
    ),

     'view_manager' => array(
         'display_not_found_reason' => true,
         'display_exceptions'       => true,

         'doctype'                  => 'HTML5',
         'not_found_template'       => 'error/404',
         'exception_template'       => 'error/index',
         'template_map' => array(
             'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
             'layout/edit'           => __DIR__ . '/../view/layout/edit.phtml',
             'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
             'error/404'               => __DIR__ . '/../view/error/404.phtml',
             'error/index'             => __DIR__ . '/../view/error/index.phtml',
         ),
         'template_path_stack' => array(
             'admin' => __DIR__ . '/../view',
         ),
     ),

    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
