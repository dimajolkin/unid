<?php

namespace UnidUser\View\Helper;

use Zend\View\Helper\AbstractHelper;
use UnidUser\Form\LoginKafedra as KafedraForm;
use Zend\View\Model\ViewModel;

class ZfcUserLoginKafedraWidget extends AbstractHelper
{
    /**
     * Login Form
     * @var LoginForm
     */
    protected $loginKafedraForm;

    /**
     * $var string template used for view
     */
    protected $viewTemplate;
    /**
     * __invoke
     *
     * @access public
     * @param array $options array of options
     * @return string
     */
    public function __invoke($options = array())
    {
        $options += array(
            'render' => true,
            'redirect' => false,
            'enableRegistration' => false,
        );

        $vm = new ViewModel(array(
            'loginForm' => $this->getLoginForm(),
            'redirect'  => $options['redirect'],
            'enableRegistration'  => $options['enableRegistration'],
        ));

        $vm->setTemplate($this->viewTemplate);
        if ($options['render']) {
            return $this->getView()->render($vm);
        }

        return $vm;
    }

    /**
     * Retrieve Login Form Object
     * @return LoginForm
     */
    public function getLoginForm()
    {
        return $this->loginKafedraForm;
    }

    /**
     * Inject Login Form Object
     * @param LoginForm $loginForm
     * @return ZfcUserLoginWidget
     */
    public function setLoginForm(KafedraForm $loginForm)
    {
        $this->loginKafedraForm = $loginForm;
        return $this;
    }

    /**
     * @param string $viewTemplate
     * @return ZfcUserLoginWidget
     */
    public function setViewTemplate($viewTemplate)
    {
        $this->viewTemplate = $viewTemplate;
        return $this;
    }
}
