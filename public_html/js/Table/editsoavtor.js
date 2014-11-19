/**
 * Created by Develop on 11.11.14.
 */
$(document).ready(function(){
    var badges = new Badges();
    var table =  new Table();
    var message = new Message();
    // от куда и куда
    var id_table = $("button[id^='form-search-user']").attr('table');

    var tbutton =  new TButton($('#table_result'), $('#table_soavtor_user'), id_table);

    var menu = new TMenu(id_table)
    menu.appendText();
    menu.appendClose();

    tbutton.setMenu(menu);

    tbutton.setFunction(function(id,name_table){
        $.ajax({
            url:"/user/Table/soavtoraddremove",
            type:"POST",
            data:{
                type:'add',
                id_login: id,
                id:$('doc').attr('id'),
                id_table:name_table
            }
        })

    },function(id,name_table){
        $.ajax({
            url:"/user/Table/soavtoraddremove",
            type:"POST",
            data:{
                type:'remove',
                id_login: id,
                id:$('doc').attr('id'),
                id_table:name_table
            }
        });
    })



    var bool = true;
    $('#table_soavtor_user  tr td:last-child').each(function(){
        if(bool != true)
        {
            var id = $(this).attr('id_doc');
            $(this).append(
                tbutton.remove(id)
            );
        }
        bool = false
    });


    $('#form-search-user').click(function(){
        message.clear();

        var text_search  = $('#text-search').val();
        if(text_search.length == 0 ){

            message.set('Поле для поиска не может быть пустым')
            return false;
        }
        var table =  $('#table_result');
        // table.find("tr[id^='user_']");
        table.find("tr[id^='user_']").remove()
        var name_table = $(this).attr('table');
        $.ajax({
            url:'/user/Table/Finduser',
            type: "POST",
            data:{
                id:$(this).attr('id_doc'),
                table: name_table,
                text: text_search
            },
            success : function(data){
                console.log(data)
                var  mas = JSON.parse(data);
                console.log(mas)
                var i = 0;
                while(true)
                {   i++;
                    if(mas[i] == undefined ) break;
                    //console.log(mas[i])
                    if(mas[i].sost == 0)
                        table.append(
                            $('<tr></tr>',{"id":'user_'+i})
                                .append($('<td />',  {"text": mas[i].FIO })
                                )
                                .append( $('<td />')
                                    .html(
                                        tbutton.append(mas[i].id)
                                        //   Button(mas[i].id, name_table, mas[i].sost, function_add, function_remove)
                                    )
                                )
                        );
                }
                if(i == 1){

                    message.set('Поиск не дал результатов..')
                }
            }
        });
    });


})