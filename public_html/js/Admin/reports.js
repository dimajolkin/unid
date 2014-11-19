/**
 * Created by Develop on 01.09.14.
 */
var Progress = function(){




}

$(document).ready(function(){
    $.ajaxSetup({
        type: "POST",
        async:false
    });

    var type = '';

    //Информация о файле на сервере
    function inf_document(document, data){

        $.ajax({
            url:'/DocumentAdmin/requestfile',
            type:'POST',
            data: {
                type: 'unid',
                id_fac: data.id_fac,
                id_table: data.id_table,
                document: document
            },
            success: function(html){
                var mas = JSON.parse(html);
                console.log(mas);
                $('#inf_file').removeClass('hidden');
                if(mas.size != undefined)
                {
                    $('#file_date').text( mas.date );
                    $('#file_size').text( mas.size );

                    $('#btn-panel-download').removeAttr("style");
                    $('#document_generate').attr("style",'display: none');

                    type = 'download';

                }else {
                    $('#inf_file').addClass('hidden');
                    $('#btn-panel-download').attr("style",'display: none')
                    $('#document_generate').removeAttr("style");

                    type = 'generate';
                }

            }
        })
    }

    $("#document_select").click(function(){

        //var Anim = new Animation( $('#doc_interfase') );

        ///  Anim.setHiddenElement($('#doc_interfase'));
        //Anim.start();


        inf_document('unid',{
            id_fac: $("#facultets option:selected").attr('name'),
            id_table: $('#tables option:selected').attr('name')
        } );

        //Anim.stop();

    });


//    //скачать документ
    $('#document_download').click(function(){

        var data  = {
            id_fac: $("#facultets option:selected").attr('name'),
            id_table: $('#tables option:selected').attr('name')
        }
        var value =  $("input[type='radio']:checked").attr('value');

        location.href = '/document/download?id_fac='+data.id_fac+'&id_table='+data.id_table;

    });
//// Переписать текущий документ тем самым обновить содержимое
//    $('#document_refresh').click(function(){
//        var value =  $("input[type='radio']:checked").attr('value');
//
//        $.ajax({
//            url:'/document/generate',
//            data:{
//                document: value
//            },
//
//            success: function(){
//                inf_document(value);
//            }
//        })
//        // inf_document(value);
//    })
//    //Сгенерировать новый документ по функционалу аналогично обновлению))

    $('#document_generate').click(function(){

        //var value =  $("input[type='radio']:checked").attr('value');
        var document = 'unid';
        var data = {
            if_fac : $("#facultets option:selected").attr('name'),
            id_table: $('#tables option:selected').attr('name')
        }

        $.ajax({
            url:'/DocumentAdmin/generate',
            type: 'POST',
            data:{
                type: 'unid',
                id_fac: data.id_fac,
                id_table: data.id_table,
                document: document
            },
            success: function(){
                inf_document('unid',data );
            }
        })

    })


});