<script>
    $(document).ready(function () {
        $('.eliminar').on('click', function () {
            Swal.fire({
                title: 'Seguro Deseas eliminar esta Revista?',
                text: "Esto ELIMINARA por completo y no tiene marcha atras!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si quiero!'
            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                    'Se ha borrado Con exito!',
                    'La revista ha sido borrada',
                    'success'
                    )
                    $(this).parent().parent().parent().delay("slow").fadeOut();     
                    let idRevista=$(this).data('revista');
                    eliminar(idRevista);
                }
            });                                                     
        
        });

        function eliminar(idRevista){
            console.log(idRevista);
            
            
            $.ajax({
                type: "DELETE",
                url: "/revista/"+idRevista,
                data: {"_token":"{{ csrf_token() }}"},
                success: function (response) {
                console.log(response);
                
                }
            });           
            
        }
    });
    

    
    
</script>