
$(document).ready(function(){
  var   Message  = new TMessage();

    setInterval(function(){
        Message.searchmessage()
    },5000);

    $('#btn_test').click(function(){
        Message.searchmessage();
        //Message.ShowMessage('23','Hello world')

    });


});