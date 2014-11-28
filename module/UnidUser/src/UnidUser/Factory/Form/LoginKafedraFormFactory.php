<?php
namespace UnidUser\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use UnidUser\Form\LoginKafedra;
use UnidUser\Form\LoginKafedraFilter;
use ZfcUser\Options;

class LoginKafedraFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceManager)
    {
        /* @var $options Options\ModuleOptions */
        $options = $serviceManager->get('zfcuser_module_options');

        $inputFilter = new LoginKafedraFilter($options);
        $form = new LoginKafedra(null, $options);
        $form->setInputFilter($inputFilter);

        return $form;
    }
}
