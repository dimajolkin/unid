<?php
namespace unid\Controller;

use unid\Model\Data;
use unid\Model\DataTable;
use unid\Model\StatusWork;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use unid\Model\Personal;
use unid\Model\KafedraTable;

use unid\Model\SendNews;
use unid\Model\SendEmail;

use unid\Form\TableForm;
use unid\Model\UserStorage;
use Zend\Json\Json;

class KafedraController extends UserController//AbstractActionController
{

    function getIdKafedra(){

        return $this->user->get('kafedra')->get('id_kaf');
    }

    function __construct()
    {
        parent::__construct();

        //   $table = new DataTable($this->getAdapter(),);
    }

    function indexAction()
    {
//        $view = new ViewModel();
//
//        $view->setVariables( array(
//                'user'=>$this->user
////                    'news'=>( new \unid\Controller\NewsController())->indexAction()
//            )
//        );
//        $StatusWork = new StatusWork(parent::getAdapter());
//
//        $personal = self::personalAction()['personal'];
//        $status = array();
//        foreach($personal as $user){
//            //$status[$user->login] =
//            $user->status = $StatusWork->getStatus($user);
//            $user->status_sost = (strpos($user->status,$StatusWork::END_STATUS))?true:false;
//        }
//
//        $request = $this->getRequest();
//        if($request->isPost()){
//            $post = new Data();
//            $post->exchangeArray($request->getPost());
//            $StatusWork->setStatus(StatusWork::BEGIN_STATUS, $post);
//
//            $News = new SendNews(parent::getAdapter());
//            $News->send(
//                $this->user->kafedra->name_kaf,
//                'Отправили отчёт на доработку',
//                $post->login
//            );
//
//
//            $this->redirect()->refresh();
//        }
//        $view->setVariable('status',$status);
//        $view->setVariable('personal',$personal);
//        return $view;
    }

    function personalAction()
    {
        parent::appendJavaScript('Table/lib');
        parent::appendJavaScript('Table/list'); //remove
        parent::appendJavaScript();
        $Personal=   new Personal($this->getAdapter(),self::getIdKafedra());
        $full_personal  = $Personal->fetchAll();

        return array(
            'personal'=> $full_personal
        );

    }
    function editAction()
    {
        parent::MessageStorgate();
        $TableUser = new \unid\Model\UserTable($this->getAdapter(), 'users');

        $form = new TableForm($this->getAdapter(), 'users');
        $form->setButtonLabel();

        $login  = $this->params('id');

        $request = $this->getRequest();
        $post = new Data();

        if ($request->isPost())
        {
            $post->exchangeArray($request->getPost());
            $post->login = $login;
            $TableUser->update($post);
            parent::MessageStorgate()->set('message','Успешно обновлено');
            $this->redirect()->refresh();
        }

        $user = $TableUser->get(array('login'=>$login))->current();
        if(!$user)  return $this->redirect()->toUrl('error/404'); //защита

        $form->load($user);
        // $form->get('login')->setAttribute('class','hidden'); //Заблокировали редактирование

        return array(
            'form'=>$form
        );
    }
    function addpersonalAction(){

        $request = $this->getRequest();
        if ($request->isPost())
        {
            $post = new Data();
            $post->exchangeArray($request->getPost());
            $Table = new DataTable($this->getAdapter(), 'users');
            $user = $Table->getTable($post->id_login);

            $SKafedra = new DataTable($this->getAdapter(), 'skafedra');
            //$SKafedra->get(array('login'=>$user->login));
            $obj = new Data();
            $obj->exchangeArray(array(
                'login'=>$user->login,
                'id_kaf'=>$this->getIdKafedra()
            ));
            $SKafedra->save($obj);


        }
        return $this->getResponse()->setContent(Json::encode( null ));
    }

    function removePersonalAction(){
        $login = $this->params('id'); //login
        $Table = new KafedraTable($this->getAdapter(), 'skafedra', self::getIdKafedra());
        $Table->remove_personal( $login );
        return $this->getResponse()->setContent(Json::encode( null ));
    }


}
