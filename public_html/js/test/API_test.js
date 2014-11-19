
$(document).ready(function(){

    var test = new TTest();
    $('#test_start').click(function(){
        test.start();
    });

    $('button[id_question]').click(function(){
        var id = $(this).text();
        test.goto(id);
    });
    $('#back_question').click(function(){
        test.answer();
        test.back();
    });
    $('#next_question').click(function(){
        test.answer();
        test.next();
    });
    $('#endtest').click(function(){
        //Message.ShowMessage('23','Hello world')
    });
    $('#btn_test_end').click(function(){
        test.answer();
        test.getResult();
    });


});