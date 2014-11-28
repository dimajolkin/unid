<?php
namespace UnidUser\Factory;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter;
use Zend\Authentication\Storage;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthenticationServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $authStorage Storage\StorageInterface */
        $authStorage = $serviceLocator->get('UnidUser\Authentication\Storage\Db');

        /* @var $authAdapter Adapter\AdapterInterface */
        $authAdapter = $serviceLocator->get('UnidUser\Authentication\Adapter\AdapterChain');

        return new AuthenticationService(
            $authStorage,
            $authAdapter
        );
    }
}
