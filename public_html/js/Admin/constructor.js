/**
 * Created by Develop on 10.08.14.
 */
$(document).ready(function(){

    $('#select_table').change(function(){
        var id_table =  $(this).find("option:selected").attr('name');

        location = '/constructor/index/'+id_table
    })
    $('#table_pole_edit label span').click(function(){
        var span = $(this);

        var content =  $('<div />',{"class":"controls controls-row"}).append(
                $('<div />',{"class":"span3"}).append(
                    $('<textarea />').text(  $(this).text() )
                )
            )
            .append(
                $('<div />',{"class":"span3"}).append(
                    $('<button />',{"class":"btn btn-success","text":"Сохранить"}).click(
                        function(){
                            span.text($('#myModal textarea').val());
                        }
                    )
                )
            )
        Modal(content ,'Редактор поля');
    });

    $('#table_pole_edit label:nth-last-child(1)').click(function(){
        var Elem = $(this)

        var content =  $('<div />',{"class":"controls controls-row"}).append(
                $('<div />',{"class":"span3"}).append(
                    $('<select  />',{"id":"new-type"})
                        .append(
                            $('<option />',{"text":"Text"})
                        ).append(
                            $('<option />',{"text":"Textarea"})
                        ).append(
                            $('<option />',{"text":"Select"})
                        )
                )
            )
            .append(
                $('<div />',{"class":"span3"}).append(
                    $('<button />',{"class":"btn btn-success","text":"Сохранить"}).click(
                        function(){
                          var select = $('#new-type option:selected').val();

                            var attribute = {"value":Elem.val(),"name":Elem.attr('name'),"class":Elem.attr("class")}

                            if(select == "Text"){
                                Elem.html( $('<input>',attribute) )
                            }else if(select == 'Textarea'){
                                Elem.html( $('<textarea/>',attribute) )
                            }else if(select == 'Select'){
                                Elem.html( $('<select />',attribute) )
                            }

                        }
                    )
                )
            )
        Modal(content ,'Редактор типа');
        $('#new-type option').each(function(){

        })
    })

})