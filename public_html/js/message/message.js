/**
 * Created by Ёлкин on 26.05.14.
 */

/**
 * Created by Develop on 22.07.14.
 */

var Message = function(){
    var obj = $('#sys_msg')
    this.Create = function(new_obj){
        obj = new_obj
        $(obj).click(function(){
            $(this).children().remove()
        })

    }

    $(obj).click(function(){
        $(this).children().remove()
    })
    this.set= function(text){
        obj.html(
            $('<div/>',{class:"alert alert-info", text: text})
        );
    }
    this.set_warning = function(text){
        obj.html(
            $('<div/>',{class:"alert alert-warning", text: text})
        );
    }
    this.set_error = function(text){
        obj.html(
            $('<div/>',{class:"alert alert-error", text: text})
        );
    }
    this.clear = function(){
        obj.text('')
    }

}


var vkAlert = function(login, text_msg, type){
    this.widtch  = 250;
    this.height = 100;
    this.img = '';
  if(type != undefined)
  {
      this.img = '<img style=" width: 50px; height: 50px; float: left;  margin-right: 5px"  src="/img/'+type+'.jpg">';
  }
    $('<div />',{"style":
            "width: "+this.widtch+"px;"+
                "height: "+this.height+"px;"+
                "background: silver;"+
                "border-radius: 15px;"+
                "padding: 10px;"+
                "z-index: 100;"+
                "display:  table-column;"+
                "margin-bottom: 5px;"+
                "position: absolute;"+
                "bottom: 0px;"}
    )
        .append('<div style="float: left;"> <span style="color: white">Сообщение от: </span> '+ login +' </div>')
        .append(
            $('<div />',{
                "style":" float: right; cursor: pointer;",
                "text":'x',
                click:function(){
                    $(this).parent().remove()
                }
            })
        )
        .append('<br><div style="padding: 10px;">'+this.img+ text_msg +'</div></div>')
        .appendTo('body');

}
