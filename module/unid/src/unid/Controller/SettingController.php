<?php
/**
 * Created by PhpStorm.
 * User: Develop
 * Date: 15.09.14
 * Time: 15:17
 */

namespace unid\Controller;


use unid\Model\Autorization;
use unid\Model\DataTable;
use unid\Model\Data;
use unid\Model\KafedraTable;
use unid\Model\UserTable;

class SettingController extends  BaseActionController {

    function userAction(){

    }
    function kafedraAction(){
        parent::appendJavaScript("Table/lib");
        parent::appendJavaScript("Table/append");
        $id_kaf = $this->user->kafedra->id_kaf;

        $KafTable = new KafedraTable(parent::getAdapter(),'kafedra');
        $kafedra = $KafTable->get(array('id_kaf'=>$id_kaf))->current();

        $request = $this->getRequest();
        if($request->isPost())
        {
            $post = new Data();
            $post->exchangeArray($request->getPost());


            $user = new Data();
            $user->login = $post->login;
            $user->password = $post->login_password;

            $UserTable = new UserTable(parent::getAdapter());
            $fuser = $UserTable->getUser($user);
            if($fuser)
            {

                $kaf = new Data();

                $kaf->exchangeArray(array(
                    'name_kaf'=>trim($post->name_kaf),
                    'zav_kaf'=>trim($user->login),
                    'password'=>$post->password,
                    'id_kaf'=>$id_kaf,
                    'id'=>$kafedra->id
                ));
                $KafTable->save($kaf);

//                if($user->login != $fuser->login)
//                {

                    $fuser->kafedra = $kaf;
                    $fuser->__year =  $this->user->__year;

                    $Auth  = new Autorization();
                   // $Auth->delete('user');
                    $Auth->setUser($fuser);

//                }

                $this->flashMessenger()->addSuccessMessage("Сохранено");

            } else {
                $this->flashMessenger()->addErrorMessage("не корретные параметры заведующего");
            }

            return $this->redirect()->refresh();

        }

        return array(
            'kaf'=>$kafedra
        );

    }


} 