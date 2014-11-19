/**
 * Created by Develop on 07.11.14.
 */

    $("#append_user_in_kaf").click(function(){

        $.ajax({
            url: "user/user/appendinkaf",
            type: "POST",
            data: {
                name_kaf: $('#login-kaf').val()
            },
            success: function(){

            }
        })


        location.reload()
    })
