@extends('backend.layouts.app')

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('backend/menu_item.title') }}
            <small>{{ trans('backend/menus.view') }}</small>
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
                        <a href="/management/menu-item/create" class="btn btn-primary pull-right">Crear nuevo</a>
                    </div>
                    <div class="box-body">
                        <table id="colors-table" class="table table-striped table-bordered dt-responsive nowrap"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>{{ trans('backend/menu_item.title') }}</th>
                                <th style="width: 120px">Accion</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($menu->getItems() as $item)
                                <tr>
                                    <td>{{ $item->getTitle() }}</td>
                                    <td><a class="btn btn-default" href="{{ "/management/menu-item/" . $item->getId(). "" }}">Ver</a>
                                        <form method="POST" action={{"/management/menu-item/" . $item->getId()."/edit-subitem"}}>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="btn btn-danger" type="submit">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">No hay items</td>
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
