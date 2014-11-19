<?php
namespace  network\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication;
use Zend\View\Renderer\PhpRenderer;
use unid\Model\File;
use unid\Model\Data;

class IndexController extends \unid\Controller\UserController//AbstractActionController
{

    function indexAction()
    {
//        $view = parent::indexAction();
//        $view->setTemplate('unid/user/index.phtml');
//        return $view;

        $request = $this->getRequest();
        if($request->isPost())
        {
            $postData = array_merge_recursive(get_object_vars($request->getPost()),get_object_vars( $request->getFiles()));
            $post = new  File( $postData);
            $post->Synch('text/');



        }


        //$file = new \unid\Model\File( '',parent::getAdapter());


    }

    function listAction()
    {


    }


}
