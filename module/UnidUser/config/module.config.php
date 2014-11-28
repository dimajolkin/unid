<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'uniduser'=> require  __DIR__.'\uniduser.config.php',
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'UnidUser\Controller\Index',
                        'action'     => 'login',
                    ),
                ),
            ),

            'uniduser' => array(
                'type' => 'Literal',
                'priority' => 1001,
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'uniduser',
                        'action'     => 'login',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'login' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => 'user/login',
                            'defaults' => array(
                                'controller' => 'uniduser',
                                'action'     => 'login',
                            ),
                        ),
                    ),
                    'authenticate' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/authenticate',
                            'defaults' => array(
                                'controller' => 'uniduser',
                                'action'     => 'authenticate',
                            ),
                        ),
                    ),
                    'logout' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/logout',
                            'defaults' => array(
                                'controller' => 'uniduser',
                                'action'     => 'logout',
                            ),
                        ),
                    ),
                    'register' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/register',
                            'defaults' => array(
                                'controller' => 'uniduser',
                                'action'     => 'register',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'UnidUser\Authentication\Adapter\Db' => 'UnidUser\Authentication\Adapter\Db',
            'UnidUser\Authentication\Storage\Db' => 'UnidUser\Authentication\Storage\Db',

        ),
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'UnidUser\Authentication\Adapter\AdapterChain'   => 'UnidUser\Authentication\Adapter\AdapterChainServiceFactory',

            'uniduser_module_options'                        => 'UnidUser\Factory\ModuleOptionsFactory',
            'zfcuser_auth_service'                          => 'UnidUser\Factory\AuthenticationServiceFactory',
            'zfcuser_login_form'                            => 'UnidUser\Factory\Form\LoginFormFactory',
            'zfcuser_login_kafedra_form'                    => 'UnidUser\Factory\Form\LoginKafedraFormFactory',
            'zfcuser_register_form'                         => 'UnidUser\Factory\Form\RegisterFormFactory',
            'zfcuser_change_password_form'                  => 'UnidUser\Factory\Form\ChangePasswordFormFactory',
            'zfcuser_change_email_form'                     => 'UnidUser\Factory\Form\ChangeEmailFormFactory',

            'zfcuser_user_mapper'                            => 'UnidUser\Factory\UserMapperFactory',
            'zfcuser_kafedra_mapper'                        => 'UnidUser\Factory\KafedraMapperFactory',

            'zfcuser_user_hydrator'                         => 'UnidUser\Factory\Mapper\UserHydratorFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'controller_plugins' => array(
        'factories' => array(
            'zfcUserAuthentication' => 'UnidUser\Factory\Controller\Plugin\ZfcUserAuthenticationFactory',
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
//            'UnidUser\Controller\Index' => 'UnidUser\Controller\IndexController',
            'UnidUser\Controller\NPR\Index' => 'UnidUser\Controller\NPR\IndexController',
            'UnidUser\Controller\Kafedra\Index' => 'UnidUser\Controller\Kafedra\IndexController',
        ),
        'factories' => array(
            'uniduser' => 'UnidUser\Factory\Controller\UserControllerFactory',
        ),
    ),
    'view_helpers' => array(
        'factories' => array(
            'zfcUserDisplayName'    => 'UnidUser\Factory\View\Helper\DisplayNameFactory',
            'zfcUserIdentity'       => 'UnidUser\Factory\View\Helper\IdentityFactory',
            'zfcUserLoginWidget'    => 'UnidUser\Factory\View\Helper\LoginWidgetFactory',
            'zfcUserLoginKafedraWidget' => 'UnidUser\Factory\View\Helper\LoginKafedraWidgetFactory'
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
            'uniduser/index/index'    => __DIR__ . '/../view/uniduser/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
            'zfcuser' => __DIR__ . '/../view',
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
