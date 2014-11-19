/**
 * Created by Develop on 05.08.14.
 */
$(document).ready(function(){

    var message = new Message();


    Assets = new Array()
    $("input[id]:not([not])").each(function(){
        Assets[$(this).attr('id')] = false;
    })

    Values = new Object()

    var Warning = function(obj, key){
        obj.parent().parent()
            .removeClass('success')
            .addClass('warning');
        Assets[key] = false;
    };

    var Success = function(obj, key){
        obj.parent().parent()
            .removeClass('warning')
            .addClass('success');
        Assets[key] = true;
        Values[key] = obj.val();

    };

    var EmptyStyle = function(obj, key){
        obj.parent().parent()
            .removeClass('warning')
            .removeClass('success');
        Assets[key] = true;
        Values[key] = obj.val();

    }


    $('#login').keyup(function(){

        $('#login').parent().parent()
            .removeClass('warning')
            .removeClass('success');
    });


    $("input[type='password']").keyup(function(){
        var pas_1 = $('#password').val();
        var pas_2 = $('#password_2').val();
        var min_size_pass = 3;
        var obj = $("input[type='password']");
        if((pas_1 != pas_2) || (pas_1.length<min_size_pass || pas_2.length<min_size_pass) )
            Warning(obj,'password');
        else
            Success(obj, 'password')
    })


    $("input[type='text'][userinfo]").keyup(function(){
        var obj  = $(this);
        if($(this).val().length == 0) {
            Warning(obj, $(this).attr('id'));
        } else  {
            Success(obj,$(this).attr('id'))
        }

    });

    $('#login_valid').click(function(){

        var login = $('#login').val();

        if(login.length == 0) {
            message.set('Логин  не может быть пустым')
            return false;
        }
        $.ajax({
            url:location.origin + '/Registration/freelogin',
            async: false,

            type:"POST",
            data:{
                login: login
            },
            success: function(res){
                var obj = $('#login');
                if(obj.attr('inverse') == 'true'){
                    if(res == 1) res = 0;else res = 1;
                }
                if(res == 1) {
                    Warning(obj, 'login');
                    // vkAlert('System','Логин занят','error')
                    message.set('Выбраный вами логин уже занят')
                }

                else {
                    Success(obj, 'login')
                    message.set('Логин свободен')

                }

            }
        });
        return false
    })
    $('#btn-register-user').click(function(){
        var form  = $('form');

        // location = "/Registration/success";

        var loc_assets = true;


        $('#login_valid').click()

        $("input[id]:not([not])").each(function(){
            if(Assets[$(this).attr('id')] == false){
                loc_assets = false;
            }
        })



        if(loc_assets){

            //alert('form_submit')
            form.submit();
            message.set('send')
            return false;
            /*$.ajax({
             url:'Registration/save',
             type:"POST",
             data: Values,
             success :function(res){
             if(res != null){
             //location = "/Registation/success";
             } else {
             message.set('Ошибка.. ')
             }

             }
             })
             */

        } else {
            message.set_warning('Не все поля заполнены')
            return false;

        }


    })

})