@extends('backend.layouts.app')

@section('scripts_head')
    <link href="/backend/plugins/select2/select2.min.css" rel="stylesheet" type="text/css"/>
@stop

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('texts.sections.design_material_sizes.title') }}
            <small>{{ trans('texts.sections.design_material_sizes.edit') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-tint"></i>  {{ trans('texts.sections.design_material_sizes.title') }}</li>
            <li class="active">{{ trans('texts.sections.design_material_sizes.edit') }}</li>
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
                    <form role="form" class="form-horizontal"  action="{{ '/management/circular-design-variant/' . $circularDesignVariant->getId() }} " method="POST" enctype="multipart/form-data">
                        <div class="box-body">
                            @include('backend.messages.session')

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">

                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.circular_design_variants.name') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="name"
                                           placeholder="{{ trans('texts.sections.circular_design_variants.name') }}" value="{{ old('name', $circularDesignVariant->getName()) }}">
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputCategory" class="col-sm-2 control-label">Categoría</label>
                                <div class="col-sm-10">
                                    <select class="form-control select2" name="category"
                                            id="inputCategory" style="width: 100%">
                                        <option></option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->getId() }}" {{ (($circularDesignVariant->getCategory() ? $circularDesignVariant->getCategory()->getId() : null) == $category->getId() ? 'selected' : '') }}>
                                                {{ $category->getName() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('design_material_size_id') ? 'has-error' : '' }}">
                                <label for="inputDesignMaterialSize" class="col-sm-2 control-label">{{ trans('texts.sections.circular_design_variants.design_material_size') }}</label>
                                <div class="col-sm-10">
                                    <select class="form-control select2"  id="inputDesignMaterialSize" name="design_material_size_id">
                                        @foreach($designMaterialSizes as $designMaterialSize)
                                            <option value="{{ $designMaterialSize->getId() }}" {{($designMaterialSize === $circularDesignVariant->getDesignMaterialSize() ? 'selected' : '')}}>{{ $designMaterialSize->getName() }}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('design_material_size_id', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('number_of_circles') ? 'has-error' : '' }}">
                                <label for="inputNumberOfCircles" class="col-sm-2 control-label">{{ trans('texts.sections.circular_design_variants.number_of_circles') }}</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputNumberOfCircles" name="number_of_circles"
                                           placeholder="{{ trans('texts.sections.circular_design_variants.number_of_circles') }}" value="{{ old('number_of_circles', $circularDesignVariant->getNumberOfCircles()) }}">
                                    {!! $errors->first('number_of_circles', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('diameter_of_circles') ? 'has-error' : '' }}">
                                <label for="inputDiameterOfCircles" class="col-sm-2 control-label">{{ trans('texts.sections.circular_design_variants.diameter_of_circles') }}</label>
                                <div class="col-sm-10">
                                    <input type="number" step="0.01" class="form-control" id="inputDiameterOfCircles" name="diameter_of_circles"
                                           placeholder="{{ trans('texts.sections.circular_design_variants.diameter_of_circles') }}" value="{{ old('diameter_of_circles', $circularDesignVariant->getDiameterOfCircles()) }}">
                                    {!! $errors->first('diameter_of_circles', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                                <label for="inputPrice"
                                       class="col-sm-2 control-label">{{ trans('texts.sections.circular_design_variants.price') }}</label>
                                <div class="col-sm-10">
                                    <input type="number" step="0.01" class="form-control" id="inputPrice"
                                           name="price"
                                           placeholder="{{ trans('texts.sections.circular_design_variants.price') }}"
                                           value="{{ old('price', $circularDesignVariant->getPrice() / 100) }}">
                                    {!! $errors->first('price', '<span class="help-block">* :message</span>') !!}
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

                                    @foreach($circularDesignVariant->getDetails() as $detail)
                                        <div id="subitem">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputDesignMaterialType" class="col-sm-2 control-label">Material</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-control select2" name="material_types[]" id="inputCategory" style="width: 100%">
                                                            @foreach($designMaterialTypes as $type)
                                                                <option value="{{ $type->getId() }}" {{ (($detail->getDesignMaterialType() ? $detail->getDesignMaterialType()->getId() : '') == $type->getId() ? "selected" : "") }}>
                                                                    {{ $type->getName() }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputArticle" class="col-sm-2 control-label">Artículo</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-control select2" name="articles[]" id="inputArticle" style="width: 100%">

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="inputPrice" class="col-sm-2 control-label">Precio</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="inputPrice" name="prices[]"
                                                               placeholder="Precio" value="{{ $detail->getPrice() / 100 }}">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-sm-1">
                                                <button id="del" class="del btn btn-danger glyphicon glyphicon-remove row-remove" type="button"></button>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>


                                {!! $errors->first('sub_items.title', '<span class="help-block">* :message</span>') !!}
                                {!! $errors->first('sub_items.url', '<span class="help-block">* :message</span>') !!}

                                <br><br>
                                <button type="button" class="btn btn-primary pull-right" id="add-sub-item"><i class="fa fa-plus"></i>Agregar</button>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-danger pull-right">{{ trans('buttons.save') }}</button>
                        </div>
                    </form>

                    <div class="box-body">
                        <h3>Vista previa</h3>
                        <img src="{{ $circularDesignVariant->getPreviewImage() }}">
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
@endsection

@section('scripts_body')
    <script src="/backend/plugins/select2/select2.full.min.js"></script>

    <script>
        $('#add-sub-item').click(function () {
            $('#subitems').append("<div id=\"subitem\">\n" +
                "\n" +
                "                                        <div class=\"col-sm-8\">\n" +
                "                                            <div class=\"form-group\">\n" +
                "                                                <label for=\"inputDesignMaterialType\" class=\"col-sm-2 control-label\">Material</label>\n" +
                "                                                <div class=\"col-sm-10\">\n" +
                "                                                    <select class=\"form-control select2\" name=\"material_types[]\" id=\"inputDesignMaterialType\" style=\"width: 100%\">\n" +
                "                                                        @foreach($designMaterialTypes as $type)\n" +
                "                                                            <option value=\"{{ $type->getId() }}\">\n" +
                "                                                                {{ $type->getName() }}\n" +
                "                                                            </option>\n" +
                "                                                        @endforeach\n" +
                "                                                    </select>\n" +
                "                                                </div>\n" +
                "                                            </div>\n" +
                "                                        </div>\n" +
                "\n" +
                "                                        <div class=\"col-sm-3\">\n" +
                "                                            <div class=\"form-group\">\n" +
                "                                                <label for=\"inputPrice\" class=\"col-sm-2 control-label\">Precio</label>\n" +
                "                                                <div class=\"col-sm-10\">\n" +
                "                                                    <input type=\"number\" step=\"0.01\" class=\"form-control\" id=\"inputUrl\" name=\"prices[]\"\n" +
                "                                                           placeholder=\"Precio\" value=\"{{ old('price') }}\">\n" +
                "                                                </div>\n" +
                "                                            </div>\n" +
                "                                        </div>\n" +
                "\n" +
                "                                        <div class=\"col-sm-1\">\n" +
                "                                            <button id=\"del\" class=\"del btn btn-danger glyphicon glyphicon-remove row-remove\" type=\"button\"></button>\n" +
                "                                        </div>\n" +
                "\n" +
                "                                    </div>");
            $('.del').on("click", function () {
                $(this).closest("#subitem").remove();
            });
        });


        $(document).ready(function () {
            $('.del').on("click", function () {
                $(this).closest("#subitem").remove();
            });

            $("#inputCategory").select2({
                placeholder: "Busque papel comestible o taza"
            });
        });
    </script>
@endsection