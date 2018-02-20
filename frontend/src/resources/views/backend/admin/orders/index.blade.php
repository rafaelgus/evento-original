@extends('backend.layouts.app')

@section('scripts_head')
    <link href="/backend/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" >
@stop


@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('texts.sections.articles.title') }}
            <small>{{ trans('texts.sections.articles.view') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-tint"></i>  {{ trans('texts.sections.articles.title') }}</li>
            <li class="active">{{ trans('texts.sections.articles.view') }}</li>
        </ol>
    </section>
@stop

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">

                        <table id="article-table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Tipo</th>
                                <th>Total</th>
                                <th>Usuario</th>
                                <th style="width: 120px">Opciones</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section><!-- /.content -->
@endsection


@section('scripts_body')
    <script src="/backend/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/backend/plugins/datatables/dataTables.bootstrap.min.js"></script>

    <!-- Page script -->
    <script>
        $(document).ready(function (e) {
            $('#article-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/management/articles/getArticles',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'category', name: 'category' },
                    { data: 'price', name: 'price' },
                    { data: 'costPrice', name: 'costPrice' },
                    { data: 'barCode', name: 'barCode' },
                    { data: 'internalCode', name: 'internalCode' },
                    {
                        "mData": null,
                        "bSortable": false,
                        "mRender": function (o) { return '<a href="/management/articles/' + o.id +'/edit" class="danger">Editar</a>'}
                    }
                ],
                language: {
                    "url": "/backend/plugins/datatables/Spanish.json"
                },
                columnDefs: [
                    {
                        "targets": [0],
                        "visible": false,
                        "searchable": false,
                        "orderable": false
                    }
                ]
            });
        });
    </script>
@endsection