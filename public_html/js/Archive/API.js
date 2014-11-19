/**
 * Created by Develop on 24.09.14.
 */
$(document).ready(function(){
    console.log('run Archive')

    var text = '/user/Table/append/1';



    year = 2013

 $('#tab-user a').each(function(){
     var obj = $(this)

     var mas =obj.attr('href').split('/');
     var id_table = mas[ mas.length -2  ]

     obj.attr('href','#archive')
     //obj.attr('ajax-href','archive/list/'+id_table+'/'+ year)
     console.log(id_table)
     obj.attr('ajax-href','/user/archive/list/'+id_table+'/'+ year)
     obj.attr('content','#history_content')


 });


    $('#archive').click(function(){



    });





});