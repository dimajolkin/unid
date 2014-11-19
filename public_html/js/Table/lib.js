/**
 * Created by Develop on 09.10.14.
 */
var Badges = function(){
    this.inc = function(){
        var num = $('#num_new_data');
        if(num.text() == ''){
            num.text('+1');
        }else{
            num.text( '+' + String(  parseInt( num.text().substr(1) )+ 1 )  );
        }
    }
    this.clear = function(){
        $('#num_new_data').text('');
    }

}
var Table = function(){
    /*  */
    this.validate = function()
    {


        var bool = true;
//        $('form > label textarea').each(function(e){
//            if($(this).val() == ''){
//                bool  = false
//                $(this).parent().attr('style','color: red')
//            }else {
//                $(this).parent().removeAttr('style')
//            }
//        })
//
//        $('form  label input').each(function(e){
//            if($(this).attr('name'))
//            {
//
//                if($(this).attr('valid'))
//                {
//                    if($(this).val() == ''){
//                        bool  = false
//                        $(this).parent().attr('style','color: red')
//                    }else {
//                        $(this).parent().removeAttr('style')
//                    }
//                }
//
//            }
//
//        })

        return bool
    }

    this.clear = function(){

        $('textarea').each(function(e){
            $(this).val('');
            $(this).parent().removeAttr('style')

        })

    }
}


var TMenu = function(id_table)
{



    var __text;
    var stek = new Array()


    this.setCap = function(text){
        __text = text
    }


    this.appendView = function(id){
        stek.push('view');
    }

    this.appendClose = function(){
        stek.push('close')
    }

    this.appendText = function()
    {
        stek.push('text')
    }
    this.appendLink = function()
    {
        stek.push('edit')
    }




    this.render = function(id) {

        var menu = $('<div />',{"class":"dropdown"})
        var href = $('<a/>',
            {"id":"drop001",
                "class":"dropdown-toggle",
                "href":"#",
                "data-toggle":"dropdown",
                "role":"button",
                "type":"button"
            })
        var caret = $('<b/>',{"class":"caret"})
        var nav_header = $('<li/>',{"class":"nav-header"})
        var ul = $("<ul/>",{"class":"dropdown-menu","aria-labelledby":"drop001","role":"menu"})


        menu.append(
            href.text(__text).append(caret)
        )

        ul.append(nav_header)
        for(var i=0;i<stek.length;i++)
        {
            if(stek[i] == 'view')
            {
                var v_href = $('<li/>').html(
                    $('<a/>',{"target":"_blank",
                        "href":"/archive/view/"+id_table+ "/" + id
                    }).append(
                            $('<i/>',{"class":"icon-flag"})
                        )
                        .append(
                            "Просмотр"
                        )
                )

                ul.append(v_href)

            }else if(stek[i] == 'close')
            {
                ul.append( nav_header );
                ul.append(
                    $('<li/>').append($('<a/>',{"href":"#","text":"Отмена"}))
                )
            }else if(stek[i]=='text')
            {
                menu.remove().removeClass("dropdown").text(__text);
            }else if(stek[i]=='edit')
            {

                var v_href = $('<li/>').html(
                    $('<a/>',{"target":"_blank",
                        "href":"/user/Table/edit/"+id_table+ "/" + id
                    }).append(
                            $('<i/>',{"class":"icon-flag"})
                        )
                        .append(
                            "Редактор"
                        )
                )

                ul.append(v_href)
            }


        }
        menu.append(ul)
        return menu
    }

}


var TButton = function(cur, sec, id_table)
{
    var tb
    var f_remove;
    var f_append;

    var bool_btn_remove = true;
    this.visibleBtnRemove = function(bool){
        bool_btn_remove = bool;
    }
    this.setFunction = function(append, remove)
    {
        f_remove = remove;
        f_append = append;
    }
    var __menu = undefined;

    this.setMenu = function(menu_){
        __menu = menu_
    }

    this.remove = function(id)
    {
        tb = $('<button />',{
            "class":"btn",
            "text":"Удалить"
        });
        tb.click(function(){
            f_remove(id, id_table);
            $(this).parents('tr').remove()

        });
        return tb;
    }
    var bool_view = true;

    this.setView = function(menu)
    {
        __menu = menu
    }

    this.append = function(id){
        tb = $('<button/>',{"class":"btn","id":id}).append(
            $('<i/>',{"class":"icon-plus"})
        ).append("Добавить")

        tb.click(function(){
            var id = $(this).attr('id');
            console.log(id)
            console.log(id_table)
            f_append(id, id_table)
            var obj = $(this).parents('tr');
            var text  = obj.find('td:eq(0)');

            console.log(text)
            if(__menu != undefined)
            {
                __menu.setCap(text.text())
                obj.find('td:eq(0)').html(
                    __menu.render(id, text)
                )
            }else {
                obj.find('td:eq(0)').html(
                    text.text()
                )
            }

            if(bool_btn_remove)
            {
                var nb = new TButton(cur,sec);
                nb.setFunction(f_append, f_remove);
                obj.find('button').parent().html(
                    nb.remove(id)
                );

            }else {
                obj.find("td:eq(2)").remove()
            }
            sec.find('tbody:eq(1)').append( obj )
        })
        return tb;
    }

}

var Button = function(id, name_table, sost, func_add, func_remove){


    var button = $('<button />',{"class":"btn"});
    if(sost != 1){
        button.text( 'Добавить' );
    } else {

        button.text('Добавлен')
            .addClass('btn-primary');
    }
    button.click(
        function(){
            var btn = $(this);
            if(btn.text() == 'Добавить'){
                btn.text('Добавлен')
                    .addClass('btn-primary');
                func_add(id,  name_table)
            } else {
                btn.text('Добавить')
                    .removeClass('btn-primary');
                func_remove(id, name_table);

            }
        })
    return button;

}


var TableChoise = function(func_remove){
    return $('<div />',{
            "class":"alert alert-block alert-error fade in"}
    ).append
        (
            $('<button />',{"class": "close",
                    "text":"×",
                    click:function(){
                        $(this).parents("td").find('div[cell]').removeClass('hidden');
                        $(this).parent().remove();
                    }}
            )
        )
        .append( '<h4 class="alert-heading" align="center">Внимание!</h4>' +
            '<p align="center">Вы действительно хотите удалить эту запись?</p> ')
        .append
        (
            $('<button />',{"class":"btn btn-warning",
                    "style":"margin-left: 30%",
                    "text":"Да",
                    click: function(){
                        func_remove(this);
                    }
                }
            )
        )
        .append
        (
            $('<button />',{"class":"btn",
                    "style":"margin-left: 30%",
                    "text":"Отмена",
                    click: function(){
                        $(this).parents("td").find('div[cell]').removeClass('hidden');
                        $(this).parent().remove();

                    }
                }
            )
        )

}