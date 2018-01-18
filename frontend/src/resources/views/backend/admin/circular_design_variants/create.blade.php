@extends('backend.layouts.app')

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('texts.sections.circular_design_variants.title') }}
            <small>{{ trans('texts.sections.circular_design_variants.new') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-tint"></i>  {{ trans('texts.sections.circular_design_variants.title') }}</li>
            <li class="active">{{ trans('texts.sections.circular_design_variants.new') }}</li>
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
                    <form role="form" class="form-horizontal" action="/management/circular-design-variant" method="POST" enctype="multipart/form-data">
                        <div class="box-body">
                            @include('backend.messages.session')

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.circular_design_variants.name') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="name"
                                           placeholder="{{ trans('texts.sections.circular_design_variants.name') }}" value="{{ old('name') }}">
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('design_material_size_id') ? 'has-error' : '' }}">
                                <label for="inputDesignMaterialSize" class="col-sm-2 control-label">{{ trans('texts.sections.circular_design_variants.design_material_size') }}</label>
                                <div class="col-sm-10">
                                    <select class="form-control select2"  id="inputDesignMaterialSize" name="design_material_size_id">
                                        @foreach($designMaterialSizes as $designMaterialSize)
                                            <option value="{{ $designMaterialSize->getId() }}">{{ $designMaterialSize->getName() }}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('design_material_size_id', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('number_of_circles') ? 'has-error' : '' }}">
                                <label for="inputNumberOfCircles" class="col-sm-2 control-label">{{ trans('texts.sections.circular_design_variants.number_of_circles') }}</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputNumberOfCircles" name="number_of_circles"
                                           placeholder="{{ trans('texts.sections.circular_design_variants.number_of_circles') }}" value="{{ old('number_of_circles') }}">
                                    {!! $errors->first('number_of_circles', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('diameter_of_circles') ? 'has-error' : '' }}">
                                <label for="inputDiameterOfCircles" class="col-sm-2 control-label">{{ trans('texts.sections.circular_design_variants.diameter_of_circles') }}</label>
                                <div class="col-sm-10">
                                    <input type="number" step="0.01" class="form-control" id="inputDiameterOfCircles" name="diameter_of_circles"
                                           placeholder="{{ trans('texts.sections.circular_design_variants.diameter_of_circles') }}" value="{{ old('diameter_of_circles') }}">
                                    {!! $errors->first('diameter_of_circles', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                                <label for="inputImage" class="col-sm-2 control-label">{{ trans('texts.sections.circular_design_variants.image') }}</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" id="inputImage" name="image"
                                           placeholder="{{ trans('texts.sections.circular_design_variants.image') }}" value="{{ old('image') }}">
                                    {!! $errors->first('image', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <!-- Horizontal Form -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Variantes</h3>
                            </div>
                            <div class="box-body">
                                <div class="subitems" id="subitems">

                                    <div id="subitem">

                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label for="inputDesignMaterialType" class="col-sm-2 control-label">Material</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control select2" name="material_types[]" id="inputDesignMaterialType" style="width: 100%">
                                                        @foreach($designMaterialTypes as $type)
                                                            <option value="{{ $type->getId() }}">
                                                                {{ $type->getName() }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="inputPrice" class="col-sm-2 control-label">Precio</label>
                                                <div class="col-sm-10">
                                                    <input type="number" step="0.01" class="form-control" id="inputUrl" name="prices[]"
                                                           placeholder="Precio" value="{{ old('price') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-1">
                                            <button id="del" class="del btn btn-danger glyphicon glyphicon-remove row-remove" type="button"></button>
                                        </div>

                                    </div>

                                </div>

                                {!! $errors->first('design_material_types.price', '<span class="help-block">* :message</span>') !!}

                                <br><br>
                                <button type="button" class="btn btn-primary pull-right" id="add-sub-item"><i class="fa fa-plus"></i>Agregar</button>
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

    <script>
        $('#add-sub-item').click(function () {

            var subitem = $('#subitem').html();

            $('#subitems').append(subitem);

            $('.del').on("click", function () {
                $(this).closest("#subitem").remove();
            });
        });

        $('.del').on("click", function () {
            $(this).closest("#subitem").remove();
        });
    </script>
@endsection