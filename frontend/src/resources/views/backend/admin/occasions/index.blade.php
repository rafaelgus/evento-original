@extends('backend.layouts.app')

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Ocasiones
            <small>Ver</small>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-tint"></i> Ocasiones</li>
            <li class="active">Ver</li>
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
                        <a href="/management/occasions/create" class="btn btn-primary pull-right">Agregar</a>
                    </div>
                    <div class="box-body">
                        <table id="colors-table" class="table table-striped table-bordered dt-responsive nowrap"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Padre</th>
                                <th style="width: 120px">Accion</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($occasions as $occasion)
                                <tr>
                                    <td>{{ $occasion->getName() }}</td>
                                    <td>{{ ($occasion->getParent() ? $occasion->getParent()->getName() : "") }}</td>
                                    <td><a href="{{ "/management/occasions/" . $occasion->getId(). "/edit" }}">Editar</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">No hay registros</td>
                                </tr>
                            @endforelse
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
