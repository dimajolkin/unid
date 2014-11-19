<?php
/**
 * Created by PhpStorm.
 * User: Develop
 * Date: 11.09.14
 * Time: 16:10
 */

namespace unid\Controller;

use unid\Model\DataTable;
use Zend\View\Model\ViewModel;
use unid\Controller\TableController;
use unid\Form\TableForm;
class ArchiveController extends TableController {


    function indexAction(){


        return array(
            'yeas'=>''
        );
    }
    function listAction(){
        $view  = new ViewModel();

        $view->setTerminal(true);

        $id_table = $this->params('id_table');

        //year
        $year  = $this->params('id');


        $tableinfo = parent::getTableInfo($id_table);
        $view->setVariable('tableInfo',$tableinfo);


        $DataTable = new DataTable(parent::getAdapter(), $tableinfo->name_table);

        $view->setVariable('table_list', $DataTable->get(array('login'=>$this->user->login, 'year'=>$year )));


        return $view;

    }

    function viewAction(){
                //$this->getEvent()->getRouteMatch()->setParam('id',$this->params('id'));
//        $view =  parent::editAction();
//        $view->setTemplate('unid\archive\view');
//        return $view;

        $this->layout('layout/edit');


        $id = $this->params('id');
        $id_table = $this->params('id_table');

        $tableInfo = parent::getTableInfo($id_table);
        $Form = new TableForm(parent::getAdapter(),$tableInfo->name_table);

        $DataTable = new DataTable(parent::getAdapter(), $tableInfo->name_table);

        $Form->load($DataTable->getTable($id));
        return array(
            'form'=>$Form
        );

    }

} 