<?php
/**
 * Created by PhpStorm.
 * User: Develop
 * Date: 25.09.14
 * Time: 14:38
 */

namespace unid\Model;


class XMLDocumentSetting {
    protected  $default_option;
    function getOptionTable(&$options, $name_table, $other_option = array() )
    {
        $default_option = $this->default_option;


        if(is_string($name_table)){
            $options[$name_table] = $default_option[$name_table];

            if(!empty($other_option)){
                foreach($other_option as $name => $val){
                   // var_dump($name);

                    $options[$name_table][$name] = $val;
                }
            }

        }elseif(is_array($name_table)){

            foreach($name_table as $table){
                $options[$table] = $default_option[$table];
            }

            if(!empty($other_option)){

                foreach($other_option as $name => $opt)
                {


                    //прогон по названиям

                    foreach($name_table as $table){

                        $options[$table][$name] = $opt;

                      //  var_dump($options[$table]);
                    }


                }
            }
        }
    }

    //настройки документа для пользователя
    function getUserOption(Data $post, $login){

        $logins =  $login; //$this->user->login;

        $options = array();
        if($post->document == 'reports_nid')  //Отчёт НИР
        {

            self::getOptionTable($options, array(
                    'themenir',
                    'scientific_meetings',
                    'rucovodstvonirs',
                    'honors'
                ), array(
                    'append_cell_fio'=>false,
                    'find_cell'=> array('login'=>$login)
                )
            );



        }elseif($post->document == 'reports_rid')
        {
            self::getOptionTable($options, array(
                'publication'
            ),  array(
                'find_cell'=> array('login'=>$login)
            ));

        }elseif($post->document == 'plan_nid')
        {
            self::getOptionTable($options, array(
                'plan_themenir',
                'plan_sm'
            ), array(
                'append_cell_fio'=>false,
                'find_cell'=> array('login'=>$login)
            ));

        }elseif($post->document == 'plan_rid')
        {
            self::getOptionTable($options, array(
                'plan_publication'
            ),  array(
                'append_cell_fio'=>false,
                'find_cell'=> array('login'=>$login)
            ));
        }


        return $options;

    }

    function getKafOption(Data $post = null, Data $personal = null){

        $logins = $personal->getLogins();

        $options = array();
        if($post->document == 'reports_nid')  //Отчёт НИР
        {
            self::getOptionTable($options, 'kaf_thematic_reports_to_nid', array(
                'find_cell'=> 'id_kaf'
            ));

            self::getOptionTable($options, array(
                'scientific_meetings',
                'rucovodstvonirs',
                'honors'
            ), array(
                'append_cell_fio'=>true,
                'find_cell'=> array('login'=>$logins)
            )
        );
            //  var_dump($options);

        }elseif($post->document == 'reports_rid')
        {
            self::getOptionTable($options, array(
                'publication'
            ), array(
                'append_cell_fio'=>true,
                'find_cell'=> array('login'=>$logins)
            ));


        }elseif($post->document == 'plan_nid')
        {
            self::getOptionTable($options, array('kaf_plan_reports_to_nid'), 'id_kaf');

            self::getOptionTable($options, 'kaf_plan_sm',
                array(
            'append_cell_fio'=>true,
            'find_cell'=> array('login'=>$logins)
        ));

        }elseif($post->document == 'plan_rid')
        {
            self::getOptionTable($options, array(
                'plan_publication'
            ), array('login'=>$logins));

        }


        return $options;
    }

    function __construct($option){
        $this->default_option = $option;
    }



} 