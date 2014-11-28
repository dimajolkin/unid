<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
//$dbParams = array(
//    'database'  => 'planandotchet',
//    'username'  => 'root',
//    'password'  => '',
//    'hostname'  => 'localhost',
//);
//
//return array(
//    'service_manager' => array(
//        'factories' => array(
//            'Zend\Db\Adapter\Adapter' => function ($sm) use ($dbParams) {
//                    return new Zend\Db\Adapter\Adapter(array(
//                        'driver'    => 'pdo',
//                        'dsn'       => 'mysql:dbname='.$dbParams['database'].';host='.$dbParams['hostname'],
//                        'database'  => $dbParams['database'],
//                        'username'  => $dbParams['username'],
//                        'password'  => $dbParams['password'],
//                        'hostname'  => $dbParams['hostname'],
//                    ));
//                },
//        ),
//    )
//);
return array(
    'db' => array(
        'driver'         => 'Pdo',
        'dsn'            => 'mysql:dbname=planandotchet;host=localhost',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'ZendDbAdapterAdapter'
            => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
);