
$(document).ready(function () {
    
    $('.descargar-ajax').on('click', function () {
        
       let token = $('input[name=_token]').val(); 
       
        $.ajax({
            type: "POST",
            data: {"_token": token.toString()},
            url: "/puntos",
            success: function (response) {
                
                $('.puntos').text(--response);
            }
        });

        
    });

    $('.notificacion-upc').on('click', function () {
        let token = $('input[name=_token]').val();
        let id_notificacion = this.dataset.id_notification;
        
        $.ajax({
            type: "POST",
            url: "/notificacion",
            data: {"_token": token, "id_notificacion": id_notificacion},
            success: function (response) {
                
            }
        });    
    });
});
