<?php

namespace unid\Controller;

use unid\Model\Data;
use unid\Model\DataTable;
use unid\Model\XMLDocumentSetting;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use unid\Model\Personal;
use unid\Model\KafedraTable;

use unid\Form\TableForm;
use unid\Model\UserStorage;

use Zend\View\Helper;
use Zend\Json\Json;

use unid\Model\File;
use Zend\Stdlib\Parameters;

use unid\XMLDoc\CreatorDocumentUNID;


class DocumentController extends BaseActionController
{
    protected $document;
    function getOptionTable(){
        if(!$this->document){
            $this->document = new XMLDocument();
        }

    }

    function __construct(){
        parent::__construct();
    }

    //Документ для Пользователя



    function getIdkafedra(){
        if( $this->user->in_vars('kafedra'))
        {
            return $this->user->kafedra->id_kaf;
        }else return null;
    }

    function indexAction(){
        parent::appendJavaScript();

        $tabs = array(
                'append' => array(
                    'active'=>'active',
                    'type'=>'reports_nid',
                    'name'=>'Отчёт НИР'
                ),
                'list'=>array(
                    'active'=>'',
                    'type'=>'reports_rid',
                    'name'=>' Отчёт РИД'
                ),
                'soavtor'=>array(
                    'active'=>'',
                    'type'=>'plan_nid',
                    'name'=>'План НИР'
                ),
                'personallist'=>array(
                    'active'=>'',
                    'type'=>'plan_rid',
                    'name'=>' План РИД'
                )

        );
        return array(
            'tabs'=>$tabs
        );
    }

    function requestfileAction(){

        $array = array();
        $request = $this->getRequest();
        if($request->isPost())
        {
            $post = new Data();
            $post->exchangeArray($request->getPost());
            $File = new File($this->user);

            if($post->document == 'unid'){

                $array = $File->getInf($post->id_fac.'/'.$post->id_tables);// unid/[id_fac]/[id_tale].xml

            }


            $array = $File->getInf($post->document);
            //$File->download('test_reports_nid');

        }
        return $this->getResponse()->setContent(Json::encode( $array ));
    }





    function generateAction(){


        $request = $this->getRequest();
        if($request->isPost())
        {
            $XMLDocumentModel = new XMLDocumentSetting($this->getServiceLocator()->get('unid.config')['document']);


            $post = new Data();
            $post->exchangeArray($request->getPost());

            $Personal = new Personal(parent::getAdapter(), self::getIdKafedra());
            $logins = $Personal->getLogins();

            $Document = new CreatorDocumentUNID(parent::getAdapter(),$this->user);
            $Document->setPersonal($Personal);

            $options = array();

            //Генерирование документа для Админа
            if($post->document == 'unid'){
                $File = new File($this->user);

                //var_dump($File->patch());

                $array = $File->getInf($post->id_fac.'/'.$post->id_tables);// unid/[id_fac]/[id_tale].xml


            }elseif(strpos($_SERVER['HTTP_REFERER'],'user/')){ //Пользовательский отчёт

                $Document->Cap(false);
                $Document->Footer(false);
                $Document->add('Персональный тематический отчёт по НИР','s81');
                $Document->add('ФИО '.$this->user->get(array('familie','name','gname')), 'pull_left');


                $options = $XMLDocumentModel->getUserOption($post, $this->user->login);
                //$options = self::getUserOption($post);

            }elseif(strpos($_SERVER['HTTP_REFERER'],'kafedra/')) {
                $options = $XMLDocumentModel->getKafOption($post, $Personal);
                //$options = self::getKafOption($post, $Personal);
            };

            foreach($options as $table => $option){
                $Document->getTableXML($table, $option);

            }
            $File = new File($this->user);
            $File->load($post->document, $Document->result());


        }


        return $this->getResponse()->setContent(Json::encode( null ));

    }

    function downloadAction(){
        $view = new ViewModel();
        //$view->setTerminal(true);
        $File = new File($this->user);
        // var_dump($_GET);
        $File->download($_GET['q']);

        return $view;
    }





}