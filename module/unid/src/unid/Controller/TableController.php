<?php
namespace unid\Controller;

use Zend\EventManager\Event;
use Zend\Form\Exception\ExtensionNotLoadedException;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\View\Console\ViewManager;
use Zend\View\Model\ViewModel;

use unid\Model\Data;
use unid\Model\SoavtorTable;

use unid\Model\UserStorage;

use unid\Model\DataTable;
use unid\Form\TableForm;
use unid\Form\TestForm;

use Zend\View\Model\JsonModel;
use Zend\View\Helper;
use Zend\Json\Json;

use unid\Plugin\Head;
/** @class append,edit,remove_tables_in_base  */
class TableController extends BaseActionController
{
    /** @metod start action */

    function indexAction()
    {
        $view = new ViewModel();
        $view->setTemplate('unid/table/index.phtml');
        parent::appendJavaScript('Table/lib');
        $id_table = $this->params('id_table');
        $TableInfo = $this->getTableInfo($id_table);
        $struct_tabs = parent::getStrucureTab($TableInfo);


        if($TableInfo->action == ''){
            unset($struct_tabs['personallist']);
        }
        if($TableInfo->soavtor == "null"){
            unset($struct_tabs['soavtor']);
        }
        //$config = $this->getServiceLocator()->get('Config')['controllers']['invokables'];

        $currnet_tab = $this->params('tab');
       if($currnet_tab)
       {
           foreach($struct_tabs as $tab =>$param)
               $struct_tabs[$tab]['active'] =  '';

           $struct_tabs[$currnet_tab]['active']= 'active';

       }
        $controller_name = substr(get_called_class(), 0 , -10);
        foreach($struct_tabs as $tab =>$param){
            $view_action  = $this->forward()->dispatch($controller_name,
                array('action'=>$tab,'id_table'=>$id_table)
            );
            $view->addChild($view_action, $tab);
        }

        $view->setVariables(array(
            'year' => $TableInfo->year,
            'group_name' => $TableInfo->group_,
            'cap' =>$TableInfo->menu,
            'tableInfo' => $TableInfo,
            'tabs'=>$struct_tabs
        ));

        return $view;
    }


    function testAction(){

        $form = new TestForm();

        $require = $this->getRequest();
        if($require->isPost())
        {
            $data = new Data();
            $data->exchangeArray($require->getPost());
            var_dump($data);
        }



        return array(
            'form'=>$form
        );
    }

    function getList()
    {
        $tableForAppend = $this->getTable( $this->tableInfo->get('name_table') );
        return $tableForAppend->get(array('login'=>$this->user->get('login'), 'year' => $this->tableInfo->year) );
    }

    function assets()
    {
        if($this->params('controller') == 'unid\Controller\Tablekafedra')  return  'full';
        return 'user';
    }

    function listAction(){
        parent::appendJavaScript();
        //sleep(5);
        $view = new ViewModel();
        //$view->setTerminal(true);

        $id_table = $this->params('id_table');
        $this->tableInfo = parent::getTableInfo($id_table);

        $tableForAppend = $this->getTable( $this->tableInfo->get('name_table') );
        $table =  $tableForAppend->get(array('login'=>$this->user->get('login'), 'year' => $this->tableInfo->year) );
        $view->setVariable('tableInfo',$this->tableInfo);
        $view->setVariable('table_list', $table);
        return $view;
    }

    function soavtorAction(){

        parent::appendJavaScript();
        $TableSoavtor = new SoavtorTable($this->getAdapter(),$this->tableInfo->name_table);
        $name_table_soavtor = $this->tableInfo->soavtor;
        return array(
            'tableInfo'=>$this->tableInfo,
            'soavtor'=>$name_table_soavtor,
            'table_soavtor'=>$TableSoavtor ->getTableSoavtor($this->tableInfo, $this->user)
        );




    }
    function editsoavtorAction()
    {
        parent::appendJavaScript('Table/lib');
       // parent::appendJavaScript('Table/soavtor');
        parent::appendJavaScript();
        //$this->layout('layout/edit');

        $id_table = $this->params('id_table');
        $id = $this->params('id');
        $tableInfo = $this->getTable('__structure_menu')->getTable( $id_table );
        $table = new SoavtorTable($this->getAdapter(),$tableInfo->get('soavtor'));
        $mas = $table->getListSoavtor( $id );
        return array(
            'doc'=>$this->getTable($tableInfo->get('name_table'))->getTable($id),
            'tableInfo'=>$tableInfo,
            'soavtor'=>$mas
        );
    }


    /** @method append_data */
    function appendAction()
    {
        parent::appendJavaScript();

        parent::MessageStorgate();

        //генерируте форму из базы
        $view  = new  ViewModel();
        $id_table = $this->params('id_table');
        if(empty($id_table)) throw new \Exception('Not parametr Id_table');

        $this->tableInfo = parent::getTableInfo($id_table);
        $year = $this->tableInfo->year;
        // var_dump($this->user);
        $form = new TableForm( $this->getAdapter(), $this->tableInfo->get('name_table'),$this->assets() );
        //получаем доступ к таблице
        $tableForAppend = $this->getTable( $this->tableInfo->get('name_table') );
        $request = $this->getRequest();
        if ($request->isPost())
        {
            $object_data = new Data();
            $object_data->exchangeArray( $request->getPost()  );
            $object_data->remove('button');
            $object_data->exchangeArray(array('year'=>$year, 'login'=>$this->user->get('login')));
            // save data
             $tableForAppend->save( $object_data );
            parent::MessageStorgate()->set('message','Запись успешно добавлена');

           $this->redirect()->toRoute('user/table',array('id_table'=>$id_table,'id'=>0,'tab'=>'append'));
          //  $this->redirect()->refresh();
        }

        $view->setVariable('form',$form);
        return $view;
    }
    //id_table, id
    function editAction()
    {
        parent::appendJavaScript('Table/lib');
        parent::appendJavaScript('Table/append');

        $storgate_msg = new UserStorage();
        if($storgate_msg->get('message')){
            $this->flashMessenger()->addSuccessMessage($storgate_msg->get('message'));
            $storgate_msg->delete('message');
        }


        $view = new ViewModel();
        //решаем от куда всязть логин
        $params = $this->params('login'); //login;
        if($params  == null)
        { $login = $this->user->get('login');
        } else $login = $params;

        $id_table = $this->params('id_table'); //Индекс таблицы
        $id_row = $this->params('id'); // индекс записи которую нам вручили на редактирование

        if(empty($id_table)) throw new \Exception('Not parametr:  action Edit Id_table');
        if(empty($id_row)) throw new \Exception('Not parametr: action Edit, id');
        // Информация о таблице
        $this->tableInfo = self::getTableInfo($id_table);
        //var_dump($this->tableInfo);

        //Форма сгенерируемая из базы
        $form = new TableForm( $this->getAdapter(), $this->tableInfo->name_table, $this->assets() );
        $form->get('button')->setOptions(array('label'=>'Сохранить'));

        $this->Table =  $this->getTable($this->tableInfo->name_table);

        //если данные поступили то сохраняем их
        $request = $this->getRequest();
        if ($request->isPost())
        {
            $object_data = new Data();
            $object_data->exchangeArray( $request->getPost()  );
            $object_data->exchangeArray(array('id'=>$id_row, 'login'=>$login));
            // save data

            $this->Table->save( $object_data );

            $storgate_msg->set('message','Информация сохранена ');


            $this->flashMessenger()->getSuccessMessages("Успешно обновлено");
            $this->redirect()->refresh();
        }
        //расстановка значений в форму
        $DataRow = $this->Table
            ->get(array('id'=>$id_row, 'login'=>$login) )
            ->current();//Выбираем поля длы вывода

        if(!$DataRow)  $this->redirect()->toUrl('error/404'); //защита

        //$form->setData($DataRow);
        $form->load($DataRow);

       // $this->layout('layout/edit');

//       return $view->setTemplate("unid/table/edit")
//              ->setTemplate('layout/edit')
         $view->setVariable('tableInfo',$this->tableInfo);
        return  $view
            ->setTemplate('unid/table/edit')
            ->setVariable('form',$form);

    }
    //Разрешим просматривать все записи по ID и ID Таблицы
    function viewAction(){
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

    function removeAction()
    {
        $id_table = $this->params('id_table');
        $id = $this->params('id');
        $tableInfo = $this->getTable('__structure_menu')->getTable( $id_table );
        $this->getTable($tableInfo->get('name_table'));
        $this->Table->delete($id);

        return $this->getResponse()->setContent(Json::encode( null ));
        //$this->redirect()->toRoute('user',array('controller'=>'Table','action'=>'append','id_table'=>$id_table, 'id'=>$id));

    }
    /** @metod find data in table */
    function SearchAction()
    {
        $array = array();
        $request = $this->getRequest();
        if ($request->isPost())
        {
            $post = new Data();
            $post->exchangeArray( $request->getPost() );
            $tableInfo = $this->getTable('__structure_menu')->getTable( $post->get('table') );

            $table = new SoavtorTable($this->getAdapter(),$tableInfo->get('name_table'));
            $soavtor_table = new DataTable($this->getAdapter(),$tableInfo->get('soavtor'));
            $this->user->set('__year', $this->getYear($tableInfo));
            $res =  $table->Search($post->text, $tableInfo->boss_row, $this->user );
            foreach($res as $obj){
                static $i;
                $i++;
                $sost = $soavtor_table->get(array('login'=>$this->user->get('login'),
                    'id_doc'=>$obj->get('id')))
                    ->count();
                $array[ $i ] = array(
                   'id'=>$obj->get('id'), //id
                    'text'=>$obj->get(  $tableInfo->get('boss_row') ), //text
                    'sost'=>$sost //sost
                );
            }
        }
        return $this->getResponse()->setContent(Json::encode( $array ));
    }
    //find user action
    function FinduserAction(){
        $array = array();
        $request = $this->getRequest();
        if ($request->isPost())
        {
            $post = new Data();
            $post->exchangeArray($request->getPost());
            $table = $this->getTable('users');

            //$users = $table->FindUser($post->get('text'));

            $users = $table->FindData(array('familie','name','gname'),$post->text);

            if($post->in_vars('id')){
                $tableInfo = $this->getTableInfo($post->get('table'));
                $table = new SoavtorTable($this->getAdapter(), $tableInfo->get('soavtor'));
                $mas = $table->getListSoavtor($post->get('id'));
                $logins = array();
                foreach($mas as $login) array_push($logins, $login->get('login'));
                $i = 1;
                foreach($users as $user){
                    $array[$i++] = array(
                        'id'=>$user->get('id'),
                        'FIO'=>$user->get('familie')." ".$user->get('name')." ".$user->get('gname'),
                        'sost'=>(in_array($user->get('login'), $logins))?1:0
                    );
                }
            }  else {
                $i = 1;
                foreach($users as $user){
                    $array[$i++] = array(
                        'id'=>$user->get('id'),
                        'FIO'=>$user->get('familie')." ".$user->get('name')." ".$user->get('gname'),
                        'sost'=>0
                    );
                }
            }
        }
        return $this->getResponse()->setContent(Json::encode( $array ));
    }
    /** Редактор соавторств */



    function soavtoraddremoveAction(){

        $request = $this->getRequest();
        if ($request->isPost())
        {
            $post = new Data();
            $post->exchangeArray( $request->getPost() );
            $tableInfo = $this->getTable('__structure_menu')->getTable( $post->get('id_table') );
            $data = new Data();
            if($post->in_vars('id_login')){
                $data->exchangeArray(array(
                    'login'=>$this->getTable('users')->getTable($post->get('id_login'))->get('login'),
                    'id_doc'=>$post->get('id')
                ));
            } else
                $data->exchangeArray(array(
                    'login'=>$this->user->login,
                    'id_doc'=>$post->id
                ));

            if($post->in_vars('type')){
                if($post->get('type') == 'add') $this->getTable( $tableInfo->soavtor )->save($data);
                elseif($post->get('type')=='remove') $this->getTable( $tableInfo->soavtor )->delete(
                    array('login'=>$data->login,'id_doc'=>$data->id_doc)
                );
            }
        }
        return $this->getResponse()->setContent(Json::encode( null ));
    }


}
