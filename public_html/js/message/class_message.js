/**
 * Created by Ёлкин on 26.05.14.
 */
TMessage = function(id_collocutor){


  this.update = function(){
      var urlform = '/Message/update';
      $.ajax({
          url: urlform,
          type: 'POST',
          data:{
              collocutor: $('#btn_send_msg').attr('sendin')
          },
          success: function (data) {
              $('#table_messages').html(data);
          },
          error: function (data) {
             // alert('Error '+data+ ' ' + urlform);
          }
      });
  };
  this.send = function(text,collocutor){
      var urlform = '/Message/send';
      $.ajax({
          url: urlform,
          type: 'POST',
          data:{
              text: text,
              id_login2: collocutor
          },
          success: function (data) {
              console.log(data)
          },
          error: function (data) {
              //alert(data+ ' ' + urlform);
          }
      });
  }
    this.searchmessage = function(){
        $.ajax({
            url: '/Message/searchmessage',
            type: 'POST',
            success: function(data){
            var obj = JSON.parse(data);
             for(var i=0;i<obj.length;i++){
                 ShowMessage(obj[i].name,obj[i].text,obj[i].id,obj[i].id_msg,obj[i].foto);
             }

            }
        });
    }
    this.Message = function(){  }

    var ShowMessage = function(name,text,id,id_msg,foto){

        var html = '<div id="num_message" nummsg="'+id_msg+'" class="window_message_box" onclick="location=\'/Message/'+id+'\'">'+
            '<div class="block_system">'+
            '<p><span>Сообщение от:</span>'+
            '<span class="message_box_login">'+name+'</span>'+
            '</p>'+
            '</div>' +
          //  '<button type="button" class="close" aria-hidden="true" onclick="$(this).parent().remove();">&times;</button>' +
            '<div class="block_text">';


        html+='<img src="'+foto+'" >';
        html+= ''+
            text +
            '</div> ' +
            '</div>';
        if(!$("#WindowDilalog").find("div[nummsg='"+id_msg+"']").length){
            $("#WindowDilalog").append(html);
        }

    }



}