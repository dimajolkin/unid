<?php
namespace unid\Controller;

use unid\Model\Autorization;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use unid\Model\Data;
use unid\Model\DataTable;

use unid\Model\UserTable;

use unid\Form\TableForm;
use Zend\Json\Json;
class RegistrationController extends AbstractActionController //TableController
{
    const USERS = 'users';

    function indexAction()
    {
        $array = array('familie' => 'Фамилия',
            'name'=>'Имя',
            'gname' => 'Отчество',
            'email'=>'Почта'
        );

        return array(
            'array'=>$array,
        );

    }
    function successAction(){


        return array(

        );
    }
    function getAdapter(){
        return $this->getServiceLocator()->get('Adapter');
    }

    function freeloginAction()
    {
        $request = $this->getRequest();
        if($request->isPost())
        {
            $post = new Data();
            $post->exchangeArray($request->getPost());
            $User = new UserTable(self::getAdapter(), self::USERS);
            $RES =  $User->get(array('login'=>$post->login))->count();

            return $this->getResponse()->setContent(Json::encode( $RES ));
        }
        return $this->getResponse()->setContent(Json::encode( null ));
    }
    function saveAction()
    {
        //Вернуть
        $request = $this->getRequest();
        if($request->isPost())
        {
            $post = new Data();
            $post->exchangeArray($request->getPost());
            // var_dump($post);
            $TableUsers = new UserTable(self::getAdapter(),self::USERS);
            $TableUsers->save($post);
            return $this->redirect()->toRoute('Registration',array('action'=>'success'));
            //return $this->getResponse()->setContent(Json::encode( $this->url('Registration',array('action'=>'success')) ));


        }

        return $this->getResponse()->setContent(Json::encode( null ));
    }
    function initzavkafAction()
    {
        $request = $this->getRequest();
        if($request->isPost())
        {
            $post = new Data();
            $post->exchangeArray($request->getPost());
            if($post->text)
            {
                $table = new DataTable(self::getAdapter(),self::USERS);
                $users = $table->FindData(array('familie','name','gname'),$post->text);
                return array(
                    'list'=>$users
                );
            }
            if($post->login)
            {
                $id_kaf = $this->params('id');
                $DataTable = new DataTable(self::getAdapter(), 'kafedra');
                $data = $DataTable->get(array('id_kaf'=>$id_kaf))->current();
                $data->zav_kaf = $post->login;
                $DataTable->save($data);

                $UserTable = new DataTable(self::getAdapter(),'users');
                $user = $UserTable->get(array('login'=>$post->login))->current();
                $user->kafedra = $data;

                $Aotoriz = new Autorization();
                $Aotoriz->setUser($user);

                //return $this->redirect()->toRoute('kafedra');
                return $this->redirect()->toRoute('home');

            }
            return array(

            );

        }

    }



    //send password in Email user
    function returnpasswordAction()
    {
        $request = $this->getRequest();
        if($request->isPost())
        {
            $post  = new  Data();

            $post->exchangeArray($request->getPost());
            $bool = false;
            if($post->login == ''){
                $bool = true;
                $this->flashMessenger()->addErrorMessage('Логин не может быть пустым');
            }
            if($post->email == ''){
                $bool = true;
                $this->flashMessenger()->addErrorMessage('Email не может быть пустым');
            }
            unset($_POST);
            if($bool) return null;

            $UserTable  = new UserTable(self::getAdapter(),self::USERS);
            $user =  $UserTable->get(array('email'=>$post->email,'login'=>$post->login))->current();

            if(is_object($user))
            {

                /* тема/subject */
                $subject = "Восстановление пароля UNID";

                /* сообщение */
                $message = '
<html>
<head>
 <title>Восстановление пароля</title>
</head>
<body>
<h1>'.$user->get(array('familie','name','gname')).'</h1>
<p>
Пароль к вашему аккаунту на <a href="http://unid.jolkin.ru">unid.ksu.edu.ru</a> :  '.$user->password.'
</p>
</body>
</html>
';

                /* Для отправки HTML-почты вы можете установить шапку Content-type. */
                $headers= "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=uft8\r\n";

                /* дополнительные шапки */
                $headers .= "From: <root@unid.jolkin.ru>\r\n";


                /* и теперь отправим из */
                if( mail($user->email, $subject, $message, $headers)) {
                    $this->flashMessenger()->addSuccessMessage('Письмо успешно отправлено на вашь почтовый ящик');
                } else {
                    $this->flashMessenger()->addErrorMessage('Ошибка отправки');;
                }

            }


        }


    }


}
