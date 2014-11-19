/**
 * Created by Develop on 09.10.14.
 */
$(document).ready(function(){

    /** remove */
    $("a[remove]").click(function(){
        var link = $(this).attr('remove');

        var funk_remove = function(this_){
            $.ajax({
                url: link,
                type:"POST",
                success:function(){
                    console.log('Удалено');

                    // vkAlert('System','remove','success')
                }
            })
            $(this_).parents("td").find('div[cell]').removeClass('hidden');
            $(this_).parents('tr').remove();
        }

        $(this).parents("div[cell]").addClass('hidden')
        $(this).parents('td').append( TableChoise( funk_remove )  );

    });

})