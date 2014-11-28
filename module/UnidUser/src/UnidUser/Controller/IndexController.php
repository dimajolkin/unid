<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace UnidUser\Controller;

use UnidUser\Mapper\Kafedra;
use UnidUser\Mapper\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


use ZfcUser\Controller\UserController as ZfcUserController;

class IndexController extends  ZfcUserController
{

    protected  $loginFormKafedra;


    public function setLoginFormKafedra($loginFormKafedra)
    {
        $this->loginFormKafedra = $loginFormKafedra;
        return $this;
    }

    public function __construct($userService, $options, $registerForm, $loginForm)
    {

        parent::__construct($userService, $options, $registerForm, $loginForm);
    }

    public function loginAction()
    {
        if ($this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute($this->options->getLoginRedirectRoute());
        }

        $request = $this->getRequest();
        $post    = $request->getPost();

        $form    = $this->loginForm;
        $formkaf = $this->loginFormKafedra;

        $view = new ViewModel();

        $fml = $this->flashMessenger()->setNamespace('zfcuser-login-form')->getMessages();
        if (isset($fml[0])) {
            $form->setMessages(
                array('identity' => array($fml[0]))
            );
        }

        $fmk= $this->flashMessenger()->setNamespace('zfcuser-login-kafedra-form')->getMessages();
        if (isset($fmk[0])) {
            $formkaf->setMessages(
                array('identity' => array($fmk[0]))
            );
        }





        if ($this->options->getUseRedirectParameterIfPresent()) {
            $redirect = $request->getQuery()->get('redirect', (!empty($post['redirect'])) ? $post['redirect'] : false);
        } else {
            $redirect = false;
        }



        if (!$request->isPost()) {
            $view->setVariables(array(
                'loginForm'=> $form,
                'loginKafedraForm'=> $formkaf,
                'kafedra_redirect'  => $redirect,
            ));
            $view->setVariable('enableRegistration', $this->options->getEnableRegistration());
            return $view;
        }


        switch($post->redirect)
        {
            case 'kafedra':
                $this->userService->setUserMapper(
                  new Kafedra()
                );

                $formkaf->setData($post);
                if (!$formkaf->isValid()) {

                    $this->flashMessenger()->setNamespace('zfcuser-login-kafedra-form')->addMessage($this->failedLoginMessage);

                    return $this->redirect()->toUrl($this->url()->fromRoute(static::ROUTE_LOGIN).($redirect ? '?redirect='. rawurlencode($redirect) : ''));
                }break;
            case 'npr':
                $form->setData($post);
                if (!$form->isValid()) {
                    $this->flashMessenger()->setNamespace('zfcuser-login-form')->addMessage($this->failedLoginMessage);
                    return $this->redirect()->toUrl($this->url()->fromRoute(static::ROUTE_LOGIN).($redirect ? '?redirect='. rawurlencode($redirect) : ''));
                }
                break;
        }

        // clear adapters
        $this->zfcUserAuthentication()->getAuthAdapter()->resetAdapters();
        $this->zfcUserAuthentication()->getAuthService()->clearIdentity();


        switch($post->redirect)
        {
            case 'kafedra':
                return $this->forward()->dispatch('uniduser', array('action' => 'authenticatekafedra'));
            case 'npr':
                return $this->forward()->dispatch(static::CONTROLLER_NAME, array('action' => 'authenticate'));
            default:
                return $this->forward()->dispatch(static::CONTROLLER_NAME, array('action' => 'authenticate'));
        }

    }
    public function authenticatekafedraAction()
    {


        if ($this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute($this->options->getLoginRedirectRoute());
        }


        $adapter = $this->zfcUserAuthentication()->getAuthAdapter();

        $redirect = $this->params()->fromPost('redirect', $this->params()->fromQuery('redirect', false));

        $result = $adapter->prepareForAuthentication($this->getRequest());


        // Return early if an adapter returned a response
        if ($result instanceof Response) {
            return $result;
        }


        $auth = $this->zfcUserAuthentication()->getAuthService() ->authenticate($adapter);


        if (!$auth->isValid()) {

            $this->flashMessenger()->setNamespace('zfcuser-login-kafedra-form')->addMessage($this->failedLoginMessage);
            $adapter->resetAdapters();

            return $this->redirect()->toUrl(
                $this->url()->fromRoute(static::ROUTE_LOGIN) .
                ($redirect ? '?redirect='. rawurlencode($redirect) : '')
            );
        }

        if ($this->options->getUseRedirectParameterIfPresent() && $redirect) {
            return $this->redirect()->toRoute($redirect);
        }

        $route = $this->options->getLoginRedirectRoute();

        if (is_callable($route)) {
            $route = $route($this->zfcUserAuthentication()->getIdentity());
        }

        return $this->redirect()->toRoute($route);
    }
}
