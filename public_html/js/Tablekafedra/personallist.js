/**
 * Created by Develop on 01.08.14.
 */
//Клиентская чать для работы с копированием данных
// tablekafedra/copy.phtml



$(document).ready(function(){

    var Copy = function(id, id_table){

        var id_array = new Array();
        id_array.push(id);

        $('#table_copy tr td:last-child').find("input:checkbox:checked").each(function(){
            var id_doc = $(this).attr('id_doc');
            if( id_doc != id ){
                id_array.push(id_doc);
                console.log($(this).attr('id_doc'))
            }
        });

        $.ajax({
            url:'/kafedra/Tablekafedra/copydataajaxt',
            type:"POST",
            data: {
                id: id_array,
                id_table: id_table
            },
            success: function(){

            }
        })

    }
    var Remove = function(){

    }

    var bool = true;
    var id_table = $('h1[id_table]').attr('id_table');

    $('#table_copy  tr td:last-child').each(function(){
        console.log($(this).html)

        if(bool != true)
        {
            var text_first = $(this).parent().find('td:first').text();

            var sost = 0;
            $('#table_content tr td:last-child').find('a:first').each(function(){
                //console.log(text_first + "  " +$(this).text());
                if( text_first.toString().trim() == $(this).text().trim()) sost = 1;
            });

            var id_doc = $(this).attr('id_doc');
            var btn_panel = $('<div />',{class:'controls controls-row'}).append(
                Button(id_doc , id_table, sost ,Copy, Remove)
            );
//            $(this).append( Button(id_doc , id_table, sost ,Copy, Remove));

//            if(id_table != 17)
//            btn_panel.append(
//               $('<div/>',{class:"checkbox"}).append(
//                $('<input>',{"type":"checkbox","class":"span2"}).attr('id_doc', id_doc)
//               )
//            );
            btn_panel.appendTo($(this));
        }




        bool = false





    });

//    $('#table_content tr td:last-child').find('a:first').each(function(){
//        var text = $(this).text()
//        if(text.length != 0){
//
//            console.log(text)
//
//
//
//        }
//
//
//    })



});