/**
 * Created by Develop on 06.08.14.
 */
/*
 <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
 <div class="modal-header">
 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
 <h3 id="myModalLabel">Заголовок</h3>
 </div>
 <div class="modal-body">



 </div>
 <div class="modal-footer">
 <button class="btn" data-dismiss="modal">Закрыть</button>
 <button class="btn btn-primary">Сохранить</button>
 </div>
 </div>

 */
var Modal =  function(content, cap_windows, option_btn) {
    var modal = $("<div />",{"class":"modal hide fade","id":"myModal",
        'tabindex':'-1',
        "role":"dialog",
        'aria-labelledby':'myModalLabel',
        'aria-hidden':'true'})
        .append(
            $("<div />",{"class":"modal-header"})
                .append(
                    $("<button />",{"type":"button","class":"close"})
                        .attr("data-dismiss","modal")
                        .attr("aria-hidden","true")
                        .text("×")

                )
                .append(
                    $("<h3 />",{"text":cap_windows,"id":"myModalLabel"})
                )
        )
        .append(
            $("<div />",{"class":"modal-body", 'height':'100%'}).html(
                $('<div />',{"class":"container-fluid"}).html(
                     content
                )
            )
        );
    var button = $("<div />",{"class":"modal-footer"});

    if(option_btn != undefined)
    {
        var button_save =  $("<button />",{"class":"btn btn-primary","text":"Сохранить"});
        var button_close =  $("<button />",{"class":"btn","text":"Отмена"})
            .attr('data-dismiss',"modal")
            .attr('aria-hidden','true');


        button.append(button_save)
            .append(button_close);

    }

    modal
        .append(button)
        .appendTo('body')
        .modal('toggle')
    ;
}

var Windows = function(url, cap_windows, button){
    if(cap_windows == undefined){
        cap_windows = '';
    }

    $.ajax({
        url:url,
        success: function(html){
            Modal(html,cap_windows );

        }
    })
}

$(document).ready(function(){
    $('a[windows]').click(function(){
        Windows();
    });

    $('a[email]').click(function(){

    });


})