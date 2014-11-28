<?php

namespace UnidUser\Form;

use Zend\Form\Element;
use ZfcBase\Form\ProvidesEventsForm;
use ZfcUser\Options\AuthenticationOptionsInterface;

class LoginKafedra extends ProvidesEventsForm
{
    /**
     * @var AuthenticationOptionsInterface
     */
    protected $authOptions;

    public function __construct($name, AuthenticationOptionsInterface $options)
    {
        $this->setAuthenticationOptions($options);
        parent::__construct($name);


        $elem = new Element\Select();
        $elem->setName('identity');
        $elem->setLabel('Название кафедры');
        $elem->setValueOptions(array(
            1=>'Demo_kafedra',
            2=>'s34fferfe',
            3=>'fsse4refsfse',
            4=>'fseesresfdsr'
        ));


        $this->add($elem);
        $emailElement = $this->get('identity');
        $label = $emailElement->getLabel('label');
        // @TODO: make translation-friendly
//        foreach ($this->getAuthenticationOptions()->getAuthIdentityFields() as $mode) {
//            $label = (!empty($label) ? $label . ' or ' : '') . ucfirst($mode);
//        }
        $emailElement->setLabel($label);
        //
        $this->add(array(
            'name' => 'credential',
            'options' => array(
                'label' => 'Пароль',
            ),
            'attributes' => array(
                'type' => 'password',
            ),
        ));

        // @todo: Fix this
        // 1) getValidator() is a protected method
        // 2) i don't believe the login form is actually being validated by the login action
        // (but keep in mind we don't want to show invalid username vs invalid password or
        // anything like that, it should just say "login failed" without any additional info)
        //$csrf = new Element\Csrf('csrf');
        //$csrf->getValidator()->setTimeout($options->getLoginFormTimeout());
        //$this->add($csrf);

        $submitElement = new Element\Button('submit');
        $submitElement
            ->setLabel('Авторизоваться на кафедре')
            ->setAttributes(array(
                'type'  => 'submit',
            ));

        $this->add($submitElement, array(
            'priority' => -100,
        ));

        $this->getEventManager()->trigger('init', $this);
    }

    /**
     * Set Authentication-related Options
     *
     * @param AuthenticationOptionsInterface $authOptions
     * @return Login
     */
    public function setAuthenticationOptions(AuthenticationOptionsInterface $authOptions)
    {
        $this->authOptions = $authOptions;
        return $this;
    }

    /**
     * Get Authentication-related Options
     *
     * @return AuthenticationOptionsInterface
     */
    public function getAuthenticationOptions()
    {
        return $this->authOptions;
    }
}
