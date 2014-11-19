/**
 * Created by Develop on 02.08.14.
 */
$(document).ready(function(){
    TableChoise(function(this_){

    });


    $('#form-search-personal').click(function(){

        var function_add = function(id,name_table){

            $.ajax({
                url:"/kafedra/kafedra/addpersonal",
                type:"POST",
                data:{
                    id_login: id
                }
            })
        }
        var function_remove= function(id,name_table){
//            $.ajax({
//                url:"/user/Table/soavtoraddremove",
//                type:"POST",
//                data:{
//                    type:'remove',
//                    id_login: id,
//                    id:$('doc').attr('id'),
//                    id_table:name_table
//                }
//            });
        }

        var text_search  = $('#text-search').val();
        var table =  $('#table_result');
        var name_table = 'users'//users

        $.ajax({
            url:'/user/user/Find',
            type: "POST",
            data:{
                id:0,
                table: 'users',
                limit: 10,
                text: text_search
            },
            success : function(data){
                var  mas = JSON.parse(data);
                console.log(mas)
                var i = 0;

                $('#table_result tr').remove();
                while(true)
                {   i++;
                    if(mas[i] == undefined ) break;
                    //console.log(mas[i])
                    var sost = 0;
                    $('#table_content tr td:last-child').find('a:first').each(function(){
                       // console.log(mas[i].FIO + "  " +$(this).text());

                        if( mas[i].FIO.toString().trim() === $(this).text().trim()) sost = 1;
                    });

                    table.append(
                        $('<tr></tr>')
                            .append($('<td />',  {"text": mas[i].FIO }))
                            .append($('<td/>',{"text":mas[i].email}))
                            .append( $('<td />').html(
                                Button(mas[i].id, name_table, sost, function_add, function_remove)))

                    );

                }
            }

        });


    });





})