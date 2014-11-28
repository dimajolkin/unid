<?php
namespace UnidUser\Factory\Mapper;

//use Zend\Crypt\Password\Bcrypt;
use UnidUser\Factory\Crypt\Crypt;
use Zend\Form\Element\Password;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcUser\Mapper;

class UserHydratorFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('zfcuser_module_options');

        $crypto  = new Crypt();
        //$crypto->setCost($options->getPasswordCost());

        return new Mapper\UserHydrator($crypto);
    }
}
