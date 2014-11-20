<?php
namespace unid\Controller;

use unid\Model\Personal;
use unid\Model\StatusWork;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use unid\Model\Data;
use unid\Model\UserTable;
use unid\Model\DataTable;
use unid\Form\TableForm;
use unid\Model\Autorization;
use unid\Model\UserStorage;

use Zend\Json\Json;
class UserController extends BaseActionController
{

    const USERS = 'users';
    const TABLE_PERSONAL_KAFEDRA = 'skafedra';
    const TABLE_KAFEDRA = 'kafedra';
    //  public $user;
    protected $table;

    function getAdapter(){
        return $this->getServiceLocator()->get('Adapter');
    }


    function  getTable($nametable = 'users'){
        $table =  new DataTable(self::getAdapter(),'__structure_stable');
        return $table->get(array('table_'=>$nametable));

    }
    //событие посылающее конец в отчёт
    function endworksostAction(){



    }

    function indexAction()
    {

        //$this->user = $this->getEvent()->getViewModel()->getVariable('user');


        $view =  new ViewModel();
        $UserTale = new UserTable(self::getAdapter(),self::USERS);//$this->user;
        $user = $UserTale->get(array('login'=>$this->user->login))->current();
        $status = new StatusWork(parent::getAdapter());
        $user_statuswork = $status->getStatus($user);


        $request = $this->getRequest();
        if($request->isPost()){
            $status->setStatus(StatusWork::END_STATUS, $user);
            $this->redirect()->refresh();
        }
        //sleep(20);

        if(strpos($user_statuswork,StatusWork::NULL_STATUS)){
            $status->setStatus(StatusWork::BEGIN_STATUS, $user);
        }
        $view->setVariable('status',$user_statuswork);

        $TableKafedra = new  DataTable(self::getAdapter(),self::TABLE_PERSONAL_KAFEDRA );
        $skaf = $TableKafedra->get(array('login'=>$user->login))->current();

        if(!empty($skaf)){
            $Kafedra = new DataTable(self::getAdapter(),self::TABLE_KAFEDRA );
            $user->name_kaf = $Kafedra->get(array('id_kaf'=>$skaf->id_kaf))->current()->name_kaf;
            unset($Kafedra);
        }

        $NewsView =  $this->forward()->dispatch('unid\Controller\News',array('action'=>'index'));
        $view->addChild($NewsView, 'news');


        return $view->setVariables(array(
            'user' => $user,
            'form_user'=> self::getTable(),

        ));


    }
    public function appendinkafAction()
    {

        $request = $this->getRequest();
        if($request->isPost())
        {
            $data = new Data();
            $data->exchangeArray($request->getPost());
            $DataTable = new DataTable(parent::getAdapter(), 'kafedra');
            $obj_kaf = $DataTable->get(array('name_kaf'=>$data->name_kaf))->current();


            $DataTable = new DataTable(parent::getAdapter(), 'skafedra');
            $data_skaf = new Data();
            $data_skaf->exchangeArray(array(
                'id_kaf'=>(int)$obj_kaf->id_kaf,
                'login'=>$this->user->login
            ));

            $DataTable->save($data_skaf);

        }
        $KafedraTable = new DataTable(parent::getAdapter(), 'kafedra');
        $KafedraTable  = $KafedraTable -> fetchAll();
        $list_kaf = array();
        foreach($KafedraTable  as $kaf)
        {
            $list_kaf[$kaf->id_kaf] = $kaf->name_kaf;
        }
        $view = new ViewModel();
        $view->setVariable('kafedra', $list_kaf);
        parent::appendJavaScript();
        $view->setTerminal(true);
        return $view;

    }
    public function editAction()
    {
        $TableUser = new UserTable($this->getAdapter(), 'users');

        $form = new TableForm($this->getAdapter(), 'users');
       // $login = $this->params('id_table');
        //$login = 'root';
        $login  = $this->user->login;

        $request = $this->getRequest();
        $post = new Data();
        if ($request->isPost())
        {
            $post->exchangeArray($request->getPost());
            $post->login = $login;
            $TableUser->update($post);

            $this->redirect()->refresh();
        }

        // $user = self::getTable()->get(array('login'=>$login));
        $user = $TableUser->get(array('login'=>$login))->current();
        if(!$user)  return $this->redirect()->toUrl('error/404'); //защита

        $form->load($user);
       // $form->get('login')->setAttribute('class','hidden'); //Заблокировали редактирование

        return array(
            'form'=>$form
        );

    }

    public function  helpAction()
    {


        return array(

        );
    }

    function FindAction(){
        $request = $this->getRequest();
        if ($request->isPost())
        {
            $post = new Data();
            $post->exchangeArray($request->getPost());
            $table = null;
            if(is_numeric($post->get('table'))){
                $tableinfo = self::getTable('__structure_menu')->getTable($post->get('name_table'));
                $table = new DataTable($this->getAdapter(), $tableinfo->get('name_table'));

            } elseif(is_string($post->get('table'))){
                $table = new DataTable($this->getAdapter(),$post->get('table'));
            }

            $result = $table->FindData(array('familie','name','gname'), $post->get('text'));

            //return $this->getResponse()->setContent(Json::encode( null ));

        }


        $table = new DataTable($this->getAdapter(),'users');

        $result = $table->FindData(array('familie','name'), $post->get('text'), $post->limit );
        $array = array();
        $i=0;
        foreach($result as $user)
        {
            $i++;
            $array[$i]= array(
                'id'=>$user->get('id'),
                'FIO'=>$user->get(array('familie','name','gname')),
                'email'=>$user->email

            );
        }

        return $this->getResponse()->setContent(Json::encode( $array ));
    }
    function kontactAction()
    {

    }


    function exitAction(){
        //$this->getServiceLocator()->get('Auth')->logout();

        $this->redirect()->toRoute('home');
    }


}
