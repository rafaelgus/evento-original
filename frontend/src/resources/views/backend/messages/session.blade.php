@if (Session::has('message'))
    <div class="alert alert-success animated fadeInDown alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        {{ Session::get('message') }}
    </div>
@endif

@if (Session::has('message-error'))
    <div class="alert alert-danger animated fadeInDown alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        {{ Session::get('message-error') }}
    </div>
@endif
