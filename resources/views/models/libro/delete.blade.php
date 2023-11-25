<script>
    $(document).ready(function () {
        $('.eliminar').on('click', function () {
            Swal.fire({
                title: 'Seguro Deseas eliminar este Libro?',
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
                    'El libro ha sido borrado',
                    'success'
                    )
                    $(this).parent().parent().parent().delay("slow").fadeOut();     
                    let idLibro=$(this).data('libro');
                    eliminar(idLibro);
                }
            });                                                     
        
        });

        function eliminar(idLibro){
            console.log(idLibro);
            
            
            $.ajax({
                type: "DELETE",
                url: "/libro/"+idLibro,
                data: {"_token":"{{ csrf_token() }}"},
                success: function (response) {
                    if (response.respuesta) {
                        
                    }                    
                }
            });           
            
        }
    });
    

    
    
</script>