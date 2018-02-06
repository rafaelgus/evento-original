@extends('backend.layouts.app')

@section('scripts_head')
    <link href="/backend/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
    <link href="/backend/plugins/datatables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet"
          type="text/css">
@stop

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('texts.sections.design_material_types.title') }}
            <small>{{ trans('texts.sections.design_material_types.view') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-tint"></i> {{ trans('texts.sections.design_material_types.title') }}</li>
            <li class="active">{{ trans('texts.sections.design_material_types.view') }}</li>
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
                        @include('backend.messages.session')

                        <div>
                            <a href="/management/design-material-type/create" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Agregar</a>
                            <br>
                            <br>
                        </div>

                        <table id="design_material_types-table" class="table table-striped table-bordered dt-responsive nowrap"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>{{ trans('texts.sections.design_material_types.name') }}</th>
                                <th>{{ trans('texts.sections.design_material_types.description') }}</th>
                                <th style="width: 120px">Accion</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
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
    <script src="/backend/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
    <script src="/backend/plugins/datatables/extensions/Responsive/js/responsive.bootstrap.min.js"></script>

    <!-- Page script -->
    <script>
        $(document).ready(function (e) {

            $('#design_material_types-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/management/design-material-type/getDatatable',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'description', name:'description'},
                    {
                        "mData": null,
                        "bSortable": false,
                        "bSearchable": false,
                        "mRender": function (o) {
                            return '<a href="/management/design-material-type/' + o.id + '/edit" class="danger">Editar</a>' +
                                ' <a href="/management/design-material-type/' + o.id + '/remove" class="danger">Eliminar</a>'
                        }
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
