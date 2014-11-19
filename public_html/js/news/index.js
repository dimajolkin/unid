/**
 * Created by Develop on 07.10.14.
 */
$(document).ready(function(){
   $('button[type="button"][class="close"]').click(function(){
       var id = $(this).attr('id');
       console.log(location.pathname+ '/news/remove/' + id.toString())

       $.ajax({
           url: location.pathname+ '/news/remove/' + id.toString()

       })
   })


})
