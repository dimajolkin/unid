<?php
namespace admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use unid\Model\UserTable;
use unid\Model\Data;
use unid\Model\Autorization;
use Zend\Authentication;
class AutorizationController extends AbstractActionController
{

    function indexAction()
    {


        $request = $this->getRequest();
        if($request->isPost())
        {
            $post = new Data();
            $post->exchangeArray($request->getPost());


            $Auth = new Autorization();
            $post->set('unid',''); //Определяем  каталог для файлов ну и помечаем кто мы
            if( $Auth->autorization($this->getServiceLocator()->get('Adapter'), $post) )
            {

                $this->redirect()->toRoute('interface');

            }

        }
        $view = new ViewModel();
        return $view;

    }


}
