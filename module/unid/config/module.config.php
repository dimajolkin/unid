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
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'unid\Controller\Autorization',
                        'action'     => 'index',
                    ),
                ),
            ),


            'Autorization' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'       => '/Autorization[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'unid\Controller',
                        'controller'    => 'Autorization',
                        'action'        => 'index',
                    ),
                )
            ),
            'Registration' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'       => '/Registration[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'unid\Controller',
                        'controller'    => 'Registration',
                        'action'        => 'index',
                    ),
                )
            ),
            //Авторизоватый пользователь

            'user' => array(
                'type'    => 'Literal',
                'priority' => 1005,
                'options' => array(
                    'route'    => '/npr',
                    'defaults' => array(
                        '__NAMESPACE__' => 'unid\Controller\NPR',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller][/:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'table' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/table[/:action][/:id_table][/:id]/[:tab]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'unid\Controller\Table',
                                'action'        => 'index',
                                'id'=>'NaN'
                            ),
                        ),
                    ),
                    'document' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/document[/:action]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'unid\Controller\Document',
                                'action'        => 'index',
                            ),
                        ),
                    ),
                    'news' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'       => '/news[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'unid\Controller',
                                'controller'    => 'News',
                                'action'        => 'index',
                            ),
                        )
                    ),
                    'archive' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'       => '/archive[/:action][/:id_table][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'unid\Controller',
                                'controller'    => 'Archive',
                                'action'        => 'index',
                            ),
                        )
                    ),
                    'help' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/help[/:action][/:id_table]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'unid\Controller\Help',
                                'action'        => 'index',
                            ),
                        ),
                    ),
                    'setting' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/setting[/:action]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'unid\Controller\Setting',
                                'action'        => 'user',

                            ),
                        ),
                    ),
                ),
            ),
            'kafedra' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/kafedra',
                    'defaults' => array(
                        '__NAMESPACE__' => 'unid\Controller',
                        'controller'    => 'Kafedra',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller][/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'table' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/table[/:action][/:id_table][/:id][/:login]/[:tab]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'unid\Controller\Tablekafedra',
                                'action'        => 'index',
                                'id'=>'',
                                'login'=>''
                            ),
                        ),
                    ),
                    'document' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/document[/:action]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'unid\Controller\Document',
                                'action'        => 'index',
                            ),
                        ),
                    ),
                    'archive' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'       => '/archive[/:action][/:id_table][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'unid\Controller',
                                'controller'    => 'Archive',
                                'action'        => 'index',
                            ),
                        )
                    ),

                    'setting' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/setting[/:action]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'unid\Controller\Setting',
                                'action'        => 'kafedra',

                            ),
                        ),
                    ),
                )
            ),


            'help' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'       => '/help[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'unid\Controller',
                        'controller'    => 'Help',
                        'action'        => 'index',
                    ),
                )
            ),

        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(

        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'unid\Controller\Table' => 'unid\Controller\TableController',
            'unid\Controller\Tablekafedra' => 'unid\Controller\TablekafedraController',
            'unid\Controller\Autorization' => 'unid\Controller\AutorizationController',
            'unid\Controller\Registration' => 'unid\Controller\RegistrationController',
            'unid\Controller\Help' =>    'unid\Controller\HelpController',
            'unid\Controller\Archive' =>    'unid\Controller\ArchiveController',

            'unid\Controller\Kafedra' => 'unid\Controller\KafedraController',
            'unid\Controller\Document' => 'unid\Controller\DocumentController',

            'unid\Controller\Setting' => 'unid\Controller\SettingController'

        ),
        'factories' => array(
            'unid\Controller\NPR\Index' =>    'unid\Factory\Controller\NPR\IndexControllerFactory',
            'unid\Controller\News' => 'unid\Factory\Controller\NewsControllerFactory',
        ),
    ),
    'strategies' => array(
        'ViewJsonStrategy',
        'ZfcTwigViewStrategy',
    ),

    'view_helpers' => array(
        'invokables' => array(
            'showMessages' => 'unid\View\Helper\ShowMessages',
            'FormRender' => 'unid\View\Helper\FormRender'
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ZfcTwigViewStrategy',
        ),
        'display_not_found_reason' => true,
        'display_exceptions'       => true,

        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/autoriz'           => __DIR__ . '/../view/layout/autoriz.phtml',

            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/edit'           => __DIR__ . '/../view/layout/edit.phtml',

            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',

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
