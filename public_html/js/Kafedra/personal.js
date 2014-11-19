/**
 * Created by Develop on 16.11.14.
 */
$(document).ready(function(){
    var id_table = 22;
    var table_result = $('#table_result');
    var table_personal = $("#table_content");

    var tbutton = new TButton(table_result, table_personal, id_table)
    tbutton.visibleBtnRemove(false);

    //Установили функции для событий

    tbutton.setFunction(function(id,name_table){
        $.ajax({
            url:"/kafedra/kafedra/addpersonal",
            type:"POST",
            data:{
                id_login: id
            }
        })
    }, function(id,name_table){
//        $.ajax({
//            url:"/user/Table/soavtoraddremove",
//            type:"POST",
//            data:{
//                type:'remove',
//                id_login: id,
//                id:$('doc').attr('id'),
//                id_table:name_table
//            }
//        });
    });

//
//    var bool = true;
//    $('#table_content  tr td:last-child').each(function(){
//        if(bool != true)
//        {
//            var id = $(this).attr('id_doc');
//            $(this).append(
//                tbutton.remove(id)
//            );
//        }
//        bool = false
//    });

    $('#form-search-personal').click(function(){

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
                    $('#table_content > tbody:eq(1) tr td:eq(0)').find('a:first').each(function(){
                        if(sost == 0)
                        {
                            if( mas[i].FIO.toString().trim() === $(this).text().trim())
                            {


                            }
                        }

                    });


                    var button;
                    if(sost == 0)
                    {
                        button = tbutton.append(mas[i].id)
                    } else button = 'Добавлен';



                    table.append(
                        $('<tr></tr>')
                            .append($('<td />',  {"text": mas[i].FIO }))
                            .append($('<td/>',{"text":mas[i].email}))
                            .append( $('<td />').html(
                              //  Button(mas[i].id, name_table, sost, function_add, function_remove)))
                               button
                            )
                            )

                    );

                }
            }

        });


    })
})