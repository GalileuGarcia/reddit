$(document).ready(function () {
    $('body').delegate('.status-share', 'click', function () {
        let post = $(".status-textarea").val();
        $.ajax({
            data: {post: post},
            type: "POST",
            dataType: 'json',
            url: 'postagem',
            success: function (data) {
                if (data['situacao'] == true) {
                    toastr.success('Nova postagem realizada com sucesso');                    
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                } else if (data['situacao'] == false) {

                }
            }
        });
    });
    
    $('body').delegate('.curtida', 'click', function (e) {
        e.preventDefault();
        let post = $(this).attr("data-id");
        $.ajax({
            data: {post: post},
            type: "POST",
            dataType: 'json',
            url: 'Postagem/like',
            success: function (data) {
                if (data['situacao'] == true) {
                   $("#svg"+data['post']).removeAttr("fill"); 
                   $("#like"+data['post']).text(data['likes']); 
                } else if (data['situacao'] == false) {
                   $("#like"+data['post']).text(data['likes']);  
                   $("#svg"+data['post']).attr('fill', 'none');
                   
                }
            }
        });
    });
    
    $('body').delegate('.comentario-social', 'click', function (e) {
        e.preventDefault();
        let post = $(this).attr("data-id");
        $("#com"+post).html(''); 
        $.ajax({
            data: {post: post},
            type: "POST",
            dataType: 'json',
            url: 'Postagem/comentario',
            success: function (data) {
                if (data['situacao'] == true) {
                   const element = document.querySelector('.anim');
                   element.classList.add('animate__animated', 'animate__fadeIn'); 
                   $("#com"+data['post']).html(data['html']); 
                   $(".comentarios-box"+data['post']).removeClass("hide");
                  
                } else if (data['situacao'] == false) {

                }
            }
        });
    });
   
});