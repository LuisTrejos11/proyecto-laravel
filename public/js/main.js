
var url= 'http://localhost:8080/proyecto-laravel/public';

window.addEventListener("load", function(){


    $('.btn-like').css('cursor', 'pointer');
    $('.btn-dislike').css('cursor', 'pointer');


    function like(){
         //boton de like
         $('.btn-like').unbind('click').click(function(){
            $(this).addClass('btn-dislike').removeClass('btn-like');
            $(this).attr('src', url+'/img/hearts-red.png');

            $.ajax({

                url : url+'/like/'+ $(this).data('id'),
                type: 'GET',
                success: function (response){
                    if(response.like){
                        console.log('has dado like a la publicacion');
                    }else{
                        console.log('error al dar like');
                    }
                    
                }

            });

            dislike();
        });

    }
  like();

  function dislike(){
     //boton de dislike
   $('.btn-dislike').unbind('click').click(function(){
        $(this).addClass('btn-like').removeClass('btn-dislike');
        $(this).attr('src', url+'/img/hearts-black.png');

        $.ajax({

            url : url+'/dislike/'+ $(this).data('id'),
            type: 'GET',
            success: function (response){
                if(response.like){
                    console.log('has dado dislike a la publicacion');
                }else{
                    console.log('error al dar dislike');
                }
                
            }

        });
        like();
    }); 
  }
   dislike();

});