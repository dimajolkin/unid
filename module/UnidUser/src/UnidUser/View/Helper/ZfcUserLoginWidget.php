<?php

namespace UnidUser\View\Helper;

use Zend\Mail\Protocol\Smtp\Auth\Login;
use Zend\View\Helper\AbstractHelper;
use UnidUser\Form\Login as LoginForm;
use UnidUser\Form\LoginKafedra as LoginKafedra;
use Zend\View\Model\ViewModel;

class ZfcUserLoginWidget extends AbstractHelper
{
    /**
     * Login Form
     * @var LoginForm
     */
    protected $loginForm;
    protected $login_redirect;
    protected $kafedra_redirect;

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
        $options = array(
            'render' => true,
            'redirect' => true,
            'enableRegistration' => false,
        );
//глоб настро login.phtml
        $vm = new ViewModel(array(
            'loginForm' => $this->getLoginForm(),
            'login_redirect'  => self::getLoginRedirect(),

            'loginKafedraForm' => $this->getLoginKafedraForm(),
            'kafedra_redirect'  => self::getKafedraRedirect(),

            'enableRegistration'  => $options['enableRegistration'],
            'redirect'=>$options['redirect']
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
        return $this->loginForm;
    }
    /**
     * Retrieve Login Form Object
     * @return LoginForm
     */
    public function getLoginKafedraForm()
    {
        return $this->loginKafedraForm;
    }

    /**
     * Inject Login Form Object
     * @param LoginForm $loginForm
     * @return ZfcUserLoginWidget
     */
    public function setLoginForm(LoginForm $loginForm)
    {
        $this->loginForm = $loginForm;
        return $this;
    }
    public  function setLoginKafedraForm(LoginKafedra $loginForm)
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



    /**
     * @return mixed
     */
    public function getKafedraRedirect()
    {
        return $this->kafedra_redirect;
    }

    /**
     * @param mixed $kafedra_redirect
     * @return ZfcUserLoginWidget
     */
    public function setKafedraRedirect($kafedra_redirect)
    {
        $this->kafedra_redirect = $kafedra_redirect;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLoginRedirect()
    {
        return $this->login_redirect;
    }

    /**
     * @param mixed $login_redirect
     * @return ZfcUserLoginWidget
     */
    public function setLoginRedirect($login_redirect)
    {
        $this->login_redirect = $login_redirect;
        return $this;
    }
}
