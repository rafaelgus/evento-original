@extends('backend.layouts.app')

@section('scripts_head')
    <link href="/backend/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" >
@stop


@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('texts.sections.categories.title') }}
            <small>{{ trans('texts.sections.categories.view') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-tint"></i>  {{ trans('texts.sections.categories.title') }}</li>
            <li class="active">{{ trans('texts.sections.categories.view') }}</li>
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

                        <input type="hidden" id="parent" value="{{$category->getId()}}">

                        <table id="categories-table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>{{ trans('texts.sections.categories.name') }}</th>
                                <th>{{ trans('texts.sections.categories.affiliate_commission') }}</th>
                                <th style="width: 120px">Accion</th>
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

            var parent = $('#parent').val();
            $('#categories-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/management/category/'+ parent +'/getSubCategory',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'affiliate_commission', name: 'affiliate_commission' },
                    {
                        "mData": null,
                        "bSortable": false,
                        "mRender": function (o) { return '<a href="/management/category/' + o.id +'/edit" class="danger">Editar</a>'}
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