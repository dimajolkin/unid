<?php
namespace unid\Controller;

use unid\Model\SendNews;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use unid\Model\Data;
use unid\Model\DataTable;
use unid\Form\TableForm;

use Zend\View\Helper;
use Zend\Json\Json;
class NewsController extends BaseActionController
{

    const NEWS_TABLE = 'news';


    function indexAction()
    {
        $TableNews = new DataTable($this->getServiceLocator()->get('Adapter'),'news');
        $news = $TableNews->get(array('login'=>$this->user->login));
        return array(
             'news'=>$news
        );

    }
    function removeAction(){
       $id =  $this->params('id');
        $News =  new SendNews(parent::getAdapter());
        $News->delete($id);
        return $this->getResponse()->setContent(Json::encode( 'yes' ));
    }
    function appendAction(){
       // var_dump($this->user);
       // if(!isset($this->user->kafedra)) throw new \Exception('Assets Close');

        $id_kaf  = $this->user->kafedra->id_kaf;
        $form = new TableForm(parent::getAdapter(), self::NEWS_TABLE);
        $request = $this->getRequest();
        if($request->isPost())
        {
            $post =new Data();
            $post->exchangeArray($request->getPost());
            $TableNews = new DataTable(parent::getAdapter(), self::NEWS_TABLE);
            $post->id_kaf = $id_kaf;
            $TableNews->save($post);
        }


        return array(
            'form'=>$form
        );

    }


}
