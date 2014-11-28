<?php
/**
 * Created by PhpStorm.
 * User: Develop
 * Date: 06.10.14
 * Time: 15:02
 */

namespace unid\Model;

use unid\Model\Data;

class StatusWork extends DataTable {
    const NULL_STATUS = 'Не приступал';
    const BEGIN_STATUS = 'Приступил к работе';
    const END_STATUS = 'Завершил работу';


    function __construct($dbAdapter){
        $name_table = '__user_statuswork';
        parent::__construct($dbAdapter, $name_table);
    }

    function setStatus($cosnt, Data $user){
        $data = new  Data();
        $status_obj = parent::get(array('login'=>$user->login))->current();

        if(!$status_obj){
            $data->exchangeArray(array('login'=>$user->login, 'status'=>$cosnt));
        } else {
            $data->exchangeArray(array('id'=>$status_obj->id,'login'=>$user->login, 'status'=>$cosnt));
        }

        parent::save($data);
    }
    function getStatus(Data $user, $add_button_refresh = false){
        try{
            $status = parent::get(array('login'=>$user->login))->current();
            if(!$status){
                return '<span class="label">'.self::NULL_STATUS.'</span>';
            }else {
                if( $status->status == self::BEGIN_STATUS){
                    return '<span class="label label-info">'.$status->status.'</span>';
                }elseif($status->status == self::END_STATUS){
                    $st = '<span class="label label-success">'.$status->status.'</span>';

                    return  $st;
                }
            }
        }catch (\Exception $er){
            return '<span class="label">'.self::NULL_STATUS.'</span>';
        }

    }

} 