


@include('templates.head')

    <!-- Loader -->
        {{-- @include('templates.layout.loader') --}}
    <!-- #Loader -->

@include('templates.layout.search_bar')

<!-- Top Bar -->
@include('templates.layout.top_bar')         
<!-- #Top Bar -->
    <section class="_content">
        @include('frontoffice.templates.layout.content',['aceptado'=> 3])            
    </section>
<script>
    window.onload=function(){
     $(function(){
         if(window.location.protocol==="https:")
             window.location.protocol="http";
     });
 }
</script>
 
@include('templates.scripts')



