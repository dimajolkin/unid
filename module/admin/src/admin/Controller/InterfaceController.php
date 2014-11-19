<?php
namespace admin\Controller;
use unid\Model\Data;
use unid\Model\UserTable;
use unid\Model\DataTable;
use Zend\View\Model\ViewModel;
use unid\Form\TableForm;

use admin\Model\FacultetTable;


class InterfaceController extends \unid\Controller\BaseActionController
{
    function __construct(){
        parent::__construct();
    }

    function personalAction()
    {

        $view = new ViewModel();
        $request = $this->getRequest();
        if($request->isPost())
        {
            $post = new Data();
            $post->exchangeArray($request->getPost());
            $UserTable = new UserTable(parent::getAdapter(), 'users');
            if($post->in_vars('find-user'))
            {
                 $result = $UserTable->FindData(array('familie','name','gname'),$post->get('find-user'), 10);
                $view->setVariable('result',$result);
            }
        }
        return $view;
    }
    function reportsAction(){

//        $Fac = new FacultetTable(parent::getAdapter(), 'facultet');
//        $Tables =  new DataTable(parent::getAdapter(),'__structure_menu');
//      //  $facults  =
// $request = $this->getRequest();
//        if($request->isPost())
//        {
//            $post = new Data();
//            $post->exchangeArray($request->getPost());
//
//            $tables = explode(' ',$post->id_kaf);
//
//            //$TableInfos = $post->id_kaf;
//
//
//        }
//
//        return array(
//            'facult' => $Fac->fetchAll(),
//            'tables'=>$Tables->fetchAll(),
//        );
    }
    function generateAction(){



    }





}