<?php
/**
 * Created by PhpStorm.
 * User: Develop
 * Date: 25.09.14
 * Time: 15:34
 */

return array(
    'menu'=>array(

    ),
    'tabs'=>array(
        'default'=>array(
            'append' => array(
                'active'=>'active',
                'name'=>'Ввод данных'
            ),
            'list'=>array(
                'active'=>'',
                'name'=>'Список'
            ),
            'soavtor'=>array(
                'active'=>'',
                'name'=>'Соавторы'
            ),
            'personallist'=>array(
                'active'=>'',
                'name'=>'Списки сотрудников'
            )
        ),
        'unid\Controller\TablekafedraController'=> array(
            'kaf_thematic_reports_to_nid' => array(
                'append'=>array(
                    'active'=>'active',
                    'name'=>'Ввод данных'
                ),
                'list'=>array(
                    'active'=>'',
                    'name'=>'Темы кафедры'
                ),
                'personallist'=>array(
                    'active'=>'',
                    'name'=>'Темы сотрудников'
                )
            ),
            'kaf_thematic_plan_to_nid' => array(
                'append'=>array(
                    'active'=>'active',
                    'name'=>'Ввод данных'
                ),
                'list'=>array(
                    'active'=>'',
                    'name'=>'Темы кафедры'
                ),
                'personallist'=>array(
                    'active'=>'',
                    'name'=>'Темы сотрудников'
                )
            ),
            'scientific_meetings' => array(
                'list'=>array(
                    'active'=>'active',
                    'name'=>'Список записей сотрудников'
                )
            ),
            'rucovodstvonirs' => array(
                'list'=>array(
                    'active'=>'active',
                    'name'=>'Список мероприятий сотрудников'
                )
            ),
            'publication'=>array(
                'list'=>array(
                    'active'=>'active',
                    'name'=>'Публикации'
                )
            ),
            'plan_publication'=>array(
                'list'=>array(
                    'active'=>'active',
                    'name'=>'Публикации'
                )
            )

        )

    ),

    'copy'=> array(
        'themenir'=>array(
            'name_table' => 'kaf_thematic_reports_to_nid',
            'convert'=>array(
                'login'=>function($Personal, $login){
                        return $Personal->getFIO($login);

                    }
            ),
            'pravilo'=> array(
                'login' =>'Memo2',
                'themenir' =>'themenir',
                'Memo2'=>'Memo5',
                'Memo5'=>'Memo3',
                'Memo3'=>'Memo4',
                'Memo4'=>'Memo6'

            )
        ),
        'plan_themenir'=>array(
            'name_table' => 'kaf_thematic_reports_to_nid',
            'convert'=>array(
                'login'=>function($Personal, $login){
                        return $Personal->getFIO($login);

                    }
            ),
            'pravilo'=> array(
                'login' =>'Memo2',
                'themenir' =>'themenir',
                'Memo2'=>'Memo5',
                'Memo5'=>'Memo3',
                'Memo3'=>'Memo4',
                'Memo4'=>'Memo6'

            )
        ),
        'plan_sm'=>array(
            'name_table' => 'kaf_plan_sm',
            'convert'=>array(
                'login'=>function($Personal, $login){
                        return $Personal->getFIO($login);

                    }
            ),
            'pravilo'=> array(
                'login' =>'FIO',
                'Memo1' =>'Memo1',
                'Memo2'=>'Memo2',
                'Memo3'=>'Memo3',
                'Memo4'=>'Memo4'

            )
        )
    ),
    //size 800
    'document'=> array(
        'themenir'=>array(
            //          'find_cell'=>'',
            'size_cell'=>'120.5 120.5 120.75 150.75 150.25 150'

        ), //themenir
        'scientific_meetings'=>
            array(
//                'find_cell'=> '',
                'size_cell'=>'150.5 200.5 150.75 160.75 160.75'//,
//                    'append_cell_fio'=>true,
//                    'text_cell_fio'=>'ФИО',

            ),
        'rucovodstvonirs'=>
            array(
//                'find_cell'=> '',
                'size_cell'=>'120.5 120.5 120.75 150.75 150.75 150.75',
                'append_cell_fio'=>true,
                'text_cell_fio'=>'ФИО',
            ),
        'honors'=>
            array(
//                'find_cell'=> '',
                'size_cell'=>'150.5 150.5 150.75 150.75',
                'append_cell_fio'=>true,
                'text_cell_fio'=>'ФИО',
            ),
        'publication' => array(
            //           'find_cell'=>'',
            'size_cell'=>'150.5 120.5 50.75 50.75 50.25 50 50 50 100',
            'append_cell_fio'=>true,
            'text_cell_fio'=>'ФИО'
        ),
        'plan_themenir'=>array(
            'size_cell'=> '120.5 120.5 120.75 150.75 150.25 150',
//            'find_cell'=>''
        ), //themenir
        'plan_sm'=>
            array(
                //              'find_cell'=> '',
                'size_cell'=>'120.5 120.5 120.75 150.75 100.75',
                'append_cell_fio'=>true,
                'text_cell_fio'=>'ФИО',

            ),
        'training_1'=> //Диссертации
            array(
                //              'find_cell'=>'',
                'size_cell'=>'90.5 90.5 90.75 90.75 90.75',
                'append_cell_fio'=>true,
                'text_cell_fio'=>'ФИО',
            ),
        'plan_publication'=> array(
//            'find_cell'=>'',
            'size_cell'=>'150.5 120.5 220.75 50.75 50.25 60 70'
        ),
        'kaf_thematic_reports_to_nid'=>array(
            'size_cell'=> '120.5 120.5 120.75 150.75 150.25 150',
//            'find_cell'=>''
        ),
        'kaf_thematic_plan_to_nid'=>array(
            'size_cell'=> '120.5 120.5 120.75 150.75 150.25 150',
            //           'find_cell'=>''
        ),
        'kaf_plan_sm'=>
            array(
                //               'find_cell'=> '',
                'size_cell'=>'120.5 120.5 120.75 150.75 100.75',
                'append_cell_fio'=>true,
                'text_cell_fio'=>'ФИО',

            ),

    )
);