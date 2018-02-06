@extends('backend.layouts.app')

@section('scripts_head')
    <link href="/backend/plugins/select2/select2.min.css" rel="stylesheet" type="text/css"/>
@stop

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Ocasiones
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-tint"></i>Ocasiones</li>
        </ol>
    </section>
@stop

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-danger">
                    <!-- form start -->
                    <form role="form" class="form-horizontal" action="{{ "/management/occasions/" . $occasion->getId() }}" method="POST">
                        <div class="box-body">
                            @include('backend.messages.session')

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">

                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">Nombre</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="name" required
                                           placeholder="Nombre" value="{{ old('name', $occasion->getName()) }}">
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                <label for="inputDescription"
                                       class="col-sm-2 control-label">{{ trans('texts.sections.categories.description') }}</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="inputDescription" name="description" rows="5"
                                              placeholder="{{ trans('texts.sections.categories.description') }}">{{ old('description', $occasion->getDescription()) }}</textarea>
                                    {!! $errors->first('description', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('occasion_id') ? 'has-error' : '' }}">
                                <label for="inputOccasion" class="col-sm-2 control-label">Ocasion Padre</label>
                                <div class="col-sm-10">
                                    <select name="occasion_id" class="form-control" id="inputOccasion">
                                        <option></option>
                                        @foreach($occasions as $item)
                                            <option  value="{{ $item->getId() }}" {{($occasion->getParent() && $occasion->getParent()->getId() === $item->getId() ? 'selected' : '')}}>{{ $item->getName() }}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('occasion_id', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-danger pull-right">{{ trans('buttons.save') }}</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
@endsection

@section('scripts_body')
    <script src="/backend/plugins/select2/select2.full.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#inputOccasion").select2({
                placeholder: "Seleccione una ocasion si corresponde"
            });
        });
    </script>
@endsection
