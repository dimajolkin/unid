<?php
namespace unid\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

use unid\Model\Data;
use unid\Model\DataTable;
use unid\Form\TableForm;

use unid\Model\Autorization;
use Zend\View\Helper;
use Zend\Json\Json;



class AutorizationController extends AbstractActionController
{
    protected $Auth;


    function indexAction()
    {
        //$this->flashMessenger()->addErrorMessage('Внимание! Система ещё не включена. ');
        //Загрузка списка кафедр
        $adapter = $this->getServiceLocator()->get('Adapter');
        $KafedraTable = new DataTable($adapter, 'kafedra');
        $KafedraTable  = $KafedraTable -> fetchAll();
        $list_kaf = array();
        foreach($KafedraTable  as $kaf)
        {
            $list_kaf[$kaf->get('id_kaf')] = $kaf->get('name_kaf');
        }
        return array(
            'kafedra' => $list_kaf
        );

    }
    function inputkafedraAction()
    {

    }

    function inputajaxAction()
    {

        $this->Auth = new Autorization();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = new Data();
            $post->exchangeArray($request->getPost()); // передаём данные в класс после проверки мы знаем что там всё правильно сделано

            $AutorizTable = new DataTable($this->getServiceLocator()->get('Adapter'),$post->get('type'));

            if($post->get('type') == 'users')
            {
                $finduser =  $AutorizTable->get(
                    array(
                        'login' => $post->get('login'),
                        'password'=>$post->get('password')))->current();
                if(!$finduser) return $this->getResponse()->setContent(Json::encode( array('code'=>false )));


                if( $finduser->in_vars('login') )
                {
                    $user = $finduser;
                    //$user->exchangeArray(array('__assets'=>md5(rand(0,100)) ));
                    $GV  = new DataTable( $this->getServiceLocator()->get('Adapter'), 'global_variable');
                    $current =$GV->get(array('var'=>'current'))->current();
                    $user->exchangeArray(array('__year'=>$current->get('year')));
                    $this->Auth->setUser( $user );
                    return $this->getResponse()->setContent(Json::encode( array('code'=>true,'url'=> '/user' )));
                }

            }


            if($post->get('type') == 'kafedra')
            {
                $finduser =  $AutorizTable->get(array('name_kaf' => $post->get('login'),
                    'password'=>$post->get('password')))->current();
                if(!$finduser) return $this->getResponse()->setContent(Json::encode( array('code'=>false )));

                if( $finduser->in_vars('name_kaf') )
                {
                    $kafedra = $finduser;
                    //$user->exchangeArray(array('__assets'=>md5(rand(0,100)) ));
                    $GV  = new DataTable( $this->getServiceLocator()->get('Adapter'), 'global_variable');
                    $current =$GV->get(array('var'=>'current'))->current();

                    $user = new Data();
                    $tableuser = new DataTable($this->getServiceLocator()->get('Adapter'),'users');

                    $url = '';
                    if($kafedra->zav_kaf != '')
                    {
                        $url = '/kafedra';
                        $user = $tableuser->get(array('login'=>$kafedra->zav_kaf))->current();//zav_kaf
                    } else {
                        $url = '/Registration/initzavkaf/'.$kafedra->id_kaf;
                        $user = new Data();
                    }


                    $user->exchangeArray(array('__year'=>$current->get('year')));
                    $user->exchangeArray(array('kafedra'=>$kafedra));

                    $this->Auth->clear();
                    $this->Auth->setUser( $user );

                    return $this->getResponse()->setContent(Json::encode( array('code'=>true,'url'=>$url )));
                }

            }

        }


    }

}
