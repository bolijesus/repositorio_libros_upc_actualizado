<script>
    $(document).ready(function () {
        $('.eliminar').on('click', function () {
            Swal.fire({
                title: 'Seguro Deseas eliminar esta Tesis?',
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
                    'La tesis ha sido borrada',
                    'success'
                    )
                    $(this).parent().parent().parent().delay("slow").fadeOut();     
                    let idTesis=$(this).data('tesis');
                    eliminar(idTesis);
                }
            });                                                     
        
        });

        function eliminar(idTesis){
            console.log(idTesis);
            
            
            $.ajax({
                type: "DELETE",
                url: "/tesis/"+idTesis,
                data: {"_token":"{{ csrf_token() }}"},
                success: function (response) {
                console.log(response);
                
                }
            });           
            
        }
    });
    

    
    
</script>