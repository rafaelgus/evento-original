@extends('backend.layouts.app')

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Sincronizacion de articulos
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-tint"></i> Menu items</li>
            <li class="active">{{ trans('backend/menus.view') }}</li>
        </ol>
    </section>
@stop

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">

                    </div>
                    <div class="box-body">
                        Cantidad de articulos por sincronizar : {{ $total }} <br>

                        <input type="button" value="sincronizar" id="sync" onclick="syncArticles()">
                    </div>
                </div>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section><!-- /.content -->
@endsection

@section('scripts_body')
    <script>
        function syncArticles() {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/management/odoo/articles/sync', true);
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    window.href = '/odoo/articles';
                }
            };
            xhr.send();
            alert('Los articulos se sincronizaran en segundo plano');
        }
    </script>
@endsection
