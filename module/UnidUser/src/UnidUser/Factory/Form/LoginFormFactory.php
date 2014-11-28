<?php
namespace UnidUser\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use UnidUser\Form\Login;
use UnidUser\Form\LoginFilter;
use ZfcUser\Options;

class LoginFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceManager)
    {
        /* @var $options Options\ModuleOptions */
        $options = $serviceManager->get('zfcuser_module_options');

        $inputFilter = new LoginFilter($options);

        $form = new Login(null, $options);
        $form->setInputFilter($inputFilter);

        return $form;
    }
}
