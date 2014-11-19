/**
 * Created by Develop on 17.07.14.
 */


$(document).ready(function(){
    var badges = new Badges();
    var table =  new Table();
    var message = new Message();
    // от куда и куда
    var id_table = $("button[id^='form-search']").attr('table');
    var tbutton =  new TButton($('#table_result'), $('#table_soavtor'),id_table);

    var menu = new TMenu(id_table)
    menu.appendView();
    menu.appendClose();

    tbutton.setView(menu)

    //Установили функции для событий
    tbutton.setFunction(function(id,name_table){
        $.ajax({
            url:"/user/Table/soavtoraddremove",
            type:"POST",
            data:{
                type:'add',
                id:id,
                id_table:name_table
            }
        });
    }, function(id,name_table){
        $.ajax({
            url:"/user/Table/soavtoraddremove",
            type:"POST",
            data:{
                type:'remove',
                id:id,
                id_table:name_table
            }
        })
    });



    var bool = true;
    $('#table_soavtor  tr td:last-child').each(function(){
        if(bool != true)
        {
            var id = $(this).attr('id_doc');
            $(this).append(
                tbutton.remove(id)
            );
        }
        bool = false
    });

    $('#form-search').click(function(){
        var text_search  = $('#text-search').val();
        if(text_search.length == 0)
        {
            Msg.set_warning('Поле поиска не может быть пустым')
            return
        }
        var table =  $('#table_result');
        table.find('tbody').remove()
        var name_table = $(this).attr('table');
        var table_soavtor = $('#table_soavtor');

        Msg = new Message()
        Msg.clear()

        $.ajax({
            url:'/user/Table/Search',
            async: false,
            type: "POST",
            data:{
                table: name_table,
                text: text_search
            },
            success : function(data){

                var  mas = JSON.parse(data);
                var i=0;
                if(mas.length == 0){
                    Msg.set_warning('Поиск не дал результатов')
                }
                while(true)
                {
                    i++;
                    if(mas[i] == undefined ) break;

                    var id = mas[i].id;
                    var sost = mas[i].sost;

                    var button = tbutton.append(id)

                   if(sost != 1)
                    table.append(
                        $('<tr></tr>')
                            .append($('<td />',  {"text": mas[i].text })  )
                            .append( $('<td />',{"class": "span2"}).html( button ) )
                    )
                }
            }
        });

    });




});