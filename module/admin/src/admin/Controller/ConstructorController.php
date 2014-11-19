<?php
namespace admin\Controller;

use unid\Model\DataTable;
use unid\Form\TableForm;
use Zend\View\Model\ViewModel;

class ConstructorController extends \unid\Controller\TableController
{

    function indexAction()
    {

        $view = new ViewModel();
        $form = null;
        $id = $this->params('id');
        if(isset($id)){
            $tableinfo = parent::getTableInfo($id);
            $form = new TableForm(parent::getAdapter(), $tableinfo->name_table);
            $view->setVariable('tableinfo', $tableinfo);
            $view->setVariable('form',$form);
        }
        $view->setVariable('tables',(new DataTable(parent::getAdapter(), '__structure_menu'))->fetchAll());
        return $view;
    }




}