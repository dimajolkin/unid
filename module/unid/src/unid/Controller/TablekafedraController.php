<?php
namespace unid\Controller;

use unid\Model\Data;
use unid\Model\Personal;

use unid\Model\KafedraTable;
use unid\Model\DataTable;
use unid\Form\TableForm;
use Zend\Http\Header\AbstractAccept;

use Zend\Json\Json;
use Zend\View\Model\ViewModel;
use unid\Model\UserStorage;
class  TablekafedraController extends TableController//AbstractActionController
{


    public $personal;
    protected  $tablekafedra;

    function getIdKafedra(){
        return $this->user->get('kafedra')->get('id_kaf');
    }
    function appendAction()
    {
        parent::appendJavaScript('Table/append');
        parent::MessageStorgate();
        //генерируте форму из базы
        $id_kaf = $this->user->kafedra->id_kaf;
        $id_table = $this->params('id_table');
        if(empty($id_table)) throw new \Exception('Not parametr Id_table');
        $this->tableInfo = parent:: getTableInfo($id_table);

        $form = new TableForm( $this->getAdapter(), $this->tableInfo->get('name_table'),$this->assets() );
        //получаем доступ к таблице
        $tableForAppend = $this->getTable( $this->tableInfo->get('name_table') );

        $request = $this->getRequest();

        $year =  $this->tableInfo->year;
        if ($request->isPost())
        {
            $object_data = new Data();
            $object_data->exchangeArray( $request->getPost()  );
            $object_data->exchangeArray(array('year'=>$year, 'id_kaf'=>self::getIdKafedra()));
            $tableForAppend->save( $object_data );

            parent::MessageStorgate()->set('message',"Запись успешно добавлена");

            $this->redirect()->toRoute('kafedra/table',array('id_table'=>$id_table,'id'=>0,'tab'=>'append'));
        }

        $view = new ViewModel();
        $view->setTemplate('unid/table/append.phtml');

        $view->setVariable('form',$form);
        return $view;
    }
    function listAction()
    {
        parent::appendJavaScript('Table/list');
        $view = new ViewModel();
        $id = $this->params('id_table');

        if(!$id){
            $id = $this->params('id');
        }


        $tableinfo = $this->getTableInfo($id);
        //Если таблицы публикации или отчёт по публикациям то надо группировать) Знаю костыль.. Но.. время.. время

        $Table = new KafedraTable($this->getAdapter(), $tableinfo, self::getIdKafedra());

        $table = $Table->fetchAll();

        // Таблицы в которых отображать шапки
        if($id == 12 or $id == 13){
            $view->setVariable('fio','');
        }elseif($id == 14 or $id == 9) {
            $cell  = ($id==14)?'type_izd':'ptype_izd';
            //Если таблицы публикации или отчёт по публикациям то надо группировать) Знаю костыль.. Но.. время.. время
            $group = array();
            foreach($table as $obj){
                array_push($group, $obj->$cell);
            }

            $group = array_unique($group);
            $view->setTemplate('unid/tablekafedra/listgroup.phtml');
            $view->setVariable('groups',$group);
            $view->setVariable('group_cell', $cell);

        } else {
            $view->setVariable('remove','');
        }

        foreach($table as $tb){

            if(! $tb->in_vars('login'))
            {
                $tb->login = 'login_kaf:'.self::getIdKafedra();
            }
        }
        $view->setVariables(array(
            'tableInfo' =>$tableinfo,
            'table_list'=>$table
        ));


        // var_dump($tableinfo);
        if($tableinfo->soavtor != 'null'){
            $view->setVariable('soavtor','true');
        }



        return $view;

    }
    function personallistAction(){
        parent::appendJavaScript();
        $id_kaf = self::getIdKafedra();
        $id_table = $this->tableInfo->params;
        $tableinfo =self::getTableInfo($id_table);

        $table = new KafedraTable($this->getAdapter(), $tableinfo->name_table ,$id_kaf);
        $personal = new Personal($this->getAdapter(),$id_kaf);

        return array(
            'tableInfo'=>$tableinfo,
            'table_list'=> $table->getList($personal->getLogins(), $tableinfo->year)
        );
    }

    function editAction(){
        parent::appendJavaScript('Table/lib');
        parent::appendJavaScript('Table/append');
        $view = new ViewModel();
        $view->setVariable('kaf',true);

        if(strpos(' '.$this->params('login'),'login_kaf:'))
        {

            $storgate_msg = new UserStorage();
            if($storgate_msg->get('message')){
                $this->flashMessenger()->addSuccessMessage($storgate_msg->get('message'));
                $storgate_msg->delete('message');
            }

            //edit отдельное редактирвоние для таблиц c id_kaf
            $id_kaf = $this->params('login');
            if(strpos('  '.$id_kaf,'login_kaf:')){
                $mas = explode(':',$id_kaf);
                $id_kaf = $mas[1];
            }

            $id_table = $this->params('id_table'); //Индекс таблицы
            $id_row = $this->params('id'); // индекс записи которую нам вручили на редактирование

            if(empty($id_table)) throw new \Exception('Not parametr:  action Edit Id_table');
            if(empty($id_row)) throw new \Exception('Not parametr: action Edit, id');
            // Информация о таблице
            $tableInfo = $this->getTable('__structure_menu')->getTable( $id_table );
            //Форма сгенерируемая из базы
            $form = new TableForm( $this->getAdapter(), $tableInfo->get('name_table'), $this->assets() );
            $form->get('button')->setOptions(array('label'=>'Сохранить'));
            $this->Table =  $this->getTable($tableInfo->name_table);
            //если данные поступили то сохраняем их
            $request = $this->getRequest();
            if ($request->isPost())
            {
                $object_data = new Data();
                $object_data->exchangeArray( $request->getPost()  );
                $object_data->exchangeArray(array('id'=>$id_row, 'id_kaf'=>$id_kaf));
                $object_data->remove('button');
                // save data
                $this->Table->save( $object_data );
                $storgate_msg->set('message','Запись успешно обновлена');
                //возвращаемся сюда же)
                $this->redirect()->refresh();
            }
            //расстановка значений в форму
            $DataRow = $this->Table
                ->get(array('id'=>$id_row, 'id_kaf'=>$id_kaf) )
                ->current();//Выбираем поля длы вывода
            //var_dump($DataRow);
            if(!$DataRow)  $this->redirect()->toUrl('error/404'); //защита

            foreach($form->caps as $cap) {
                // echo $cap;
                $form->get($cap)->setValue( $DataRow->get($cap)  );
            }

           // $this->layout()->setTemplate('layout/edit');

            $view->setVariable('form', $form);

            $view->setVariable('tableInfo', $tableInfo);

            $view->setTemplate('unid/table/edit');
            return $view;

        } else {
            $view = parent::editAction();
        }

        return $view;
    }

// событие для копирования, объединерия данных
    function copydataajaxtAction()
    {
        //параметры копирования
        $config_copy = $this->getServiceLocator()->get('unid.config')['copy'];
        $request = $this->getRequest();
        if ($request->isPost())
        {
            $post = new Data();
            $post->exchangeArray($request->getPost());
            $kaf_tableinfo  = self::getTableInfo( $post->id_table);
            $user_tableinfo = self::getTableInfo( $kaf_tableinfo->params );
            $user_table = self::getTable($user_tableinfo->name_table);

            $dt = new DataTable(parent::getAdapter(),'users');
            $objects = $dt->convert(
                $user_table->getTable($post->id),
                $config_copy[$user_tableinfo->name_table]
            );
            $DataTable = new DataTable(parent::getAdapter(), $kaf_tableinfo->name_table);
            $objects->id_kaf =  self::getIdKafedra();
            $objects->year = parent::getYear($user_tableinfo);
            var_dump($objects);
            $DataTable->save($objects);
        }

        return $this->getResponse()->setContent(Json::encode( null ));
    }





}
