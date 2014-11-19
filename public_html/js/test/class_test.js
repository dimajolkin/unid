/**
 * Created by Ёлкин on 29.05.14.
 */
var TTest = function(){
    var id_question = new Array();
    var currnet;
    var max;
    var result = new Array();

    this.start = function(){

        $('#numquestion >div > button').each(function(e){
            var id =  $(this).attr('id_question');
            id_question.push(id);
        });

        currnet = 0;
        max = id_question.length-2;
        console.log(max);
        $('#infpanel').removeClass('hidden');
        $('#numquestion').removeClass('hidden');
        $('#closepanel').removeClass('hidden');
        getQuestion(id_question[0]);
    }
    this.getResult = function(){
        console.log(result)

          var a = new Array();
        for(var i=0;i<result.length;i++)
        if(result[i] != undefined) a.push(result[i]);


        console.log(a);
        $.ajax({
            url:'/Test/result',
            type:'POST',
            async:false,
            data:{
                size: a.length,
                data:result,
                id_test:$('h1[id_test]').attr('id_test')
            },
            success: function(data){
             $('#testbody').html(data);
            }
        })


    }
    this.answer = function(){
        var reply_bool = new Array();
        $('#reply').find('input:checked').each(function(){
            reply_bool.push($(this).attr('name'));
        });
        console.log(reply_bool);
        result[id_question[currnet]] = reply_bool;
        //console.log(result);
    }
    this.next = function(){

        if(currnet > max){
           console.log('Дальше некуда')
        } else {
            currnet++;
            getQuestion(id_question[currnet]);
            console.log(currnet)
        }
    }
    this.back = function(){

        if(currnet <= 0 ){
            console.log('Дальше некуда')
        } else {
            currnet--;
            getQuestion(id_question[currnet]);
            console.log(currnet)
        }

    }
    this.goto = function(cur){
        currnet = cur-1;
        getQuestion(id_question[currnet]);
    }


    var getQuestion =  function(id_question){

        $("#numquestion >div").find("button[class~='btn-primary']")
            .removeClass('btn-primary')
            .addClass('btn-success');

        $("#numquestion >div").find("button[id_question='"+id_question+"']")
            .removeClass('btn-success')
            .addClass('btn-primary');

        $.ajax({
            url:'/Test/ajaxgetquestion',
            type:'POST',
            data:{
                id_question: id_question
            },
            async: false,
            success: function(data){
                var obj = JSON.parse(data);
                var reply  = $('#reply > ul').empty();
                $('#question >p').html(obj[0]);

                for(var i=0;i<obj[1].length;i++){
                    var id = obj[1][i].id;
                    var str = '';
                   if ( result[id_question] != undefined){
                       for(var j=0;j<result[id_question].length;++j){
                           if(result[id_question][j] == id){
                               str = 'checked';
//                               $("#numquestion >div").find("button[id_question='"+id_question+"']")
//                                   .removeClass('btn-primary')
//                                   .addClass('btn-btn-danger');
                           }
                       }

                   }


                    reply.append('<li><label><input '+str+' id="reply_'+id+'" type="checkbox" name="'+id+'" class="span2">'+
                        '<span>'+obj[1][i].reply+'</span></label></li>');
                }
            },
            error: function(){

            }
        });
    }


};