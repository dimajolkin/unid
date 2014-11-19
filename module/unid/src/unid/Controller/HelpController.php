<?php
namespace unid\Controller;

use unid\Model\DataTable;
use Zend\Mvc\Controller\AbstractActionController;
//use Zend\View\Helper\ViewModel;
use Zend\View\Model\ViewModel;


class HelpController extends AbstractActionController
{

    function __construct()
    {

    }

    function userAction()
    {

    }
    function indexAction(){

    }
    function tableAction()
    {

    }

    function pagesAction()
    {
        $view = new ViewModel();
        $dir =__DIR__.'/../../../view/unid/help/'.$this->params('id').'.phtml';
        if(file_exists($dir))
        {
            $view->setTemplate("unid/help/".$this->params('id'));
        } else {
            $view->setTemplate("unid/help/notfount");
        }
        $view->setTerminal(true);
        return $view;
    }


    function kafedraAction()
    {

    }

}


