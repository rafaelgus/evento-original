@if($errors->any())
    <div class="alert alert-danger animated fadeInDown alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong>{{ trans('auth.error.please_fix') }}</strong>
        <ul>
            @foreach ($errors->all() as $message)
                <li>{{ (trans($message)) }}</li>
            @endforeach
        </ul>
    </div>
@endif
