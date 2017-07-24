@extends('backend.layouts.app')

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('texts.sections.article.title') }}
            <small>{{ trans('texts.sections.article.edit') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-tint"></i>  {{ trans('texts.sections.article.title') }}</li>
            <li class="active">{{ trans('texts.sections.article.edit') }}</li>
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
                    <form role="form" class="form-horizontal" action="/management/articles/{{$article->getId()}}" method="POST" enctype="multipart/form-data">
                        <div class="box-body">
                            @include('backend.messages.session')

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">

                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.name') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="name"
                                           placeholder="{{ trans('texts.sections.article.name') }}" value="{{ old('name', $article->getName())}}">
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.description') }}</label>
                                <div class="col-sm-10">
                                    <textarea rows="10" class="form-control" id="description" name="description" placeholder="{{ trans('texts.sections.article.description') }}">{{ old('description', $article->getDescription())}}</textarea>

                                    {!! $errors->first('description', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('shortDescription') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.shortDescription') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="shortDescription" value="{{ old('shortDescription', $article->getShortDescription())}}" placeholder="{{ trans('texts.sections.article.shortDescription') }}">

                                    {!! $errors->first('shortDescription', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('barCode') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.barCode') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="barCode"
                                           placeholder="{{ trans('texts.sections.article.barCode') }}" value="{{ old('barCode', $article->getBarCode()) }}">
                                    {!! $errors->first('barCode', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('internalCode') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.internalCode') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="internalCode"
                                           placeholder="{{ trans('texts.sections.article.internalCode') }}" value="{{ old('internalCode', $article->getInternalCode()) }}">
                                    {!! $errors->first('internalCode', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">venta por</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="priceType" name="priceTypeDisabled" value="{{ $priceType }}" disabled>
                                        @if($priceType == 1) <option value="1">Unidad</option> @endif
                                        @if($priceType == 2)<option value="2">Granel</option> @endif
                                    </select>
                                </div>
                                <input type="hidden" value="{{$priceType}}" name="priceType">
                            </div>
                            <div id="granel" class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">cantidad</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="quantity" name="price"
                                           placeholder="{{ trans('texts.sections.article.quantity') }}" value="{{ old('price') }}">
                                    {!! $errors->first('price', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}" id="priceInput">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.price') }}</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="price" name="price"
                                           placeholder="{{ trans('texts.sections.article.price') }}" value="{{ old('price',  $article->getPrice()) }}">
                                    {!! $errors->first('price', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group" id="agregar">
                                <div class="col-md-12">
                                    <button type="button" id="addPrice" class="btn btn-danger pull-right">Agregar</button>
                                </div>
                            </div>
                            <div class="row" id="table-price">
                                <div class="col-md-2"></div>
                                <div class="col-md-6">
                                    <table class="table table-bordered" id="tablePrice">
                                        <tr>
                                            <th>#</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th>Opcion</th>
                                        </tr>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <input type="hidden" value="none" id="priceId">
                                <div id="hiddens">

                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('costPrice') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.costPrice') }}</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputName" name="costPrice"
                                           placeholder="{{ trans('texts.sections.article.costPrice') }}" value="{{ old('costPrice', $article->getCostPrice())}}">
                                    {!! $errors->first('costPrice', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.slug') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="slug"
                                           placeholder="{{ trans('texts.sections.article.slug') }}" value="{{ old('slug', $article->getSlug())}}">
                                    {!! $errors->first('slug', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.status') }}</label>
                                <div class="col-sm-10">
                                    <select class="form-control select2" id="status" name="status">
                                        <option value="draft">Borrador</option>
                                        <option value="published">Publicado</option>
                                        <option value="discontinued">Descontinuado</option>
                                    </select>
                                    {!! $errors->first('status', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.categories') }}</label>
                                <div class="col-sm-10">
                                    <select class="form-control select2" id="categories" name="category">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->getId() }}">{{$category->getName()}}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('brand') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.brand') }}</label>
                                <div class="col-sm-10">
                                    <select class="form-control select2" id="brands" name="brand">
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->getId() }}" >{{$brand->getName()}}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('license') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.license') }}</label>
                                <div class="col-sm-10">
                                    <select class="form-control select2" id="license" name="license">
                                        @foreach($licenses as $license)
                                            <option value="{{ $license->getId() }}" >{{$license->getName()}}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('license', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('tags') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.tags') }}</label>
                                <div class="col-sm-10">
                                    <select multiple class="form-control select2" id="tags" name="tags[]">
                                        @foreach($tags as $tag)
                                            <option value="{{ $tag->getId() }}" {{(in_array($tag, $article->getTags()->toArray())? 'selected' : '')}} >{{$tag->getName()}}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('tags', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('allergens[]') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.allergens') }}</label>
                                <div class="col-sm-10">
                                    <select multiple class="form-control select2" id="allergens" name="allergens[]">
                                        @foreach($allergens as $allergen)
                                            <option value="{{ $allergen->getId() }}" {{(in_array($allergen, $article->getAllergens()->toArray())? 'selected' : '')}} >{{$allergen->getName()}}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('allergens[]', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('colors[]') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.colors') }}</label>
                                <div class="col-sm-10">
                                    <select multiple class="form-control select2" id="colors" name="colors[]">
                                        @foreach($colors as $color)
                                            <option value="{{ $color->getId() }}" {{(in_array($color, $article->getColors()->toArray())? 'selected' : '')}} >{{$color->getName()}}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('colors[]', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('ingredients[]') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.ingredients') }}</label>
                                <div class="col-sm-10">
                                    <select multiple class="form-control select2" id="ingredients" name="ingredients[]">
                                        @foreach($ingredients as $ingredient)
                                            <option value="{{ $ingredient->getId() }}" {{(in_array($ingredient, $article->getIngredients()->toArray())? 'selected' : '')}} >{{$ingredient->getName()}}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('ingredients[]', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('flavours[]') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.flavours') }}</label>
                                <div class="col-sm-10">
                                    <select multiple class="form-control select2" id="flavours" name="flavours[]" style="width: 100%">
                                        @foreach($flavours as $flavour)
                                            <option value="{{ $flavour->getId() }}" {{(in_array($flavour, $article->getFlavours()->toArray())? 'selected' : '')}}>{{$flavour->getName()}}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('flavours[]', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="box-footer">
                                @foreach($article->getImages() as $image)
                                <ul class="mailbox-attachments clearfix">
                                    <li id="image_{{$image->getId()}}">
                                        <span class="mailbox-attachment-icon"><img style="max-width: 162px; max-height: 198px;" src="/management/articles/storage/{{$image->getPath()}}"></span>
                                        <div class="mailbox-attachment-info">
                                            <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip">
                                                </i> Sep2014-report.pdf</a>
                                            <span class="mailbox-attachment-size">1,245 KB
                                                <a href="#" class="btn btn-default btn-xs pull-right deletePicture" id="{{$image->getId()}}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                                </ul>
                            </div>

                            @if (count($article->getImages()) != 10)
                                <div id="fine-uploader-gallery"></div>
                            @endif
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-danger pull-right">{{ trans('buttons.save') }}</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section><!-- /.content -->
@endsection

@section('scripts_body')
    <link href="/css/select2.min.css" rel="stylesheet" />
    <script src="/js/select2.min.js"></script>

    <link href="/backend/css/fine-uploader-gallery.css" rel="stylesheet" />

    <script src="/backend/js/fine-uploader.js"></script>

    <script type="text/javascript">
        $('#categories').select2();
        $('#ingredients').select2();
        $('#license').select2();
        $('#status').select2();
        $('#tags').select2();
        $('#allergens').select2();
        $('#colors').select2();
        $('#flavours').select2();
        $('#brands').select2();
        loadTable();

        $('#description').wysihtml5();

        if($('#priceType').val() == 1) {
            $('#agregar').hide();
            $('#granel').hide();
            $('#table-price').hide();
        }

        $('#addPrice').click(function() {
            var quantity = $('#quantity').val();
            var price = $('#price').val();
            var rowCount = $('#tablePrice tr').length;

            if ($('#priceId').val() != 'none') {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    }
                });

                $.ajax({
                    context: this,
                    url: '/management/articles/prices/update/',
                    type: 'POST',
                    data: {
                        id : $('#priceId').val(),
                        price: price,
                        quantity: quantity
                    }
                }).done(function(result) {
                    alert(result.message);
                    loadTable();
                });
            } else {
                if (parseInt(quantity) > 0 && parseFloat(price) > 0) {
                    $('#tablePrice tr:last').after('<tr><td>'+rowCount+'</td><td>'+quantity+'</td><td>'+price+'</td></tr>');

                    $('#hiddens').append('<input type="hidden" value="'+quantity+'" name="quantities[]">');
                    $('#hiddens').append('<input type="hidden" value="'+price+'" name="prices[]">');

                    $('#quantity').val('');
                    $('#price').val();
                } else {
                    alert('El precio y la cantidad debe ser mayor a 0');
                }
            }
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function loadTable() {
            if ($('#priceType').val() == 2) {
                $.ajax({
                    context : this,
                    url: '/management/articles/prices/{{ $article->getId() }}',
                    type: 'GET'
                }).done(function (result) {
                    $("tablePrice").find("tr:gt(0)").remove();
                    $.each(result, function (i, option) {
                        $('#tablePrice').append('<tr><td class="priceId">'+option.id+'</td><td class="priceQuantity">'+option.quantity+'</td><td class="priceAmount">'+option.price+'</td><td><a href="#" class="editPrice" id="price_'+option.id+'">Editar</a> </td></tr>');
                    });
                })
            }
        }

        $('#priceType').change(function() {
            var type = parseInt($('#priceType').val());

            if (type == 1) {
                $('#agregar').hide();
                $('#granel').hide();
                $('#table-price').hide();
            }
            if (type == 2) {
                $('#agregar').show();
                $('#granel').show();
                $('#table-price').show();
            }
        });

        $('.deletePicture').click(function() {
            var id = $(this).attr('id');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });

            $.ajax({
                context: this,
                url: '/management/articles/uploads/delete/'+ id,
                type: 'POST'
            }).done(function (result) {
                $('#image_'+id).remove();
            });
        });

        $(document).on('click', '.editPrice', function() {
            var row = $(this).parent().parent();

            var id = $($($(row).find('td')[0])).text();
            var quantity = $($($(row).find('td')[1])).text();
            var amount = $($($(row).find('td')[2])).text();

            $('#quantity').val(quantity);
            $('#price').val(amount);
            $('#priceId').val(id);
        });

    </script>
    <script type="text/template" id="qq-template-gallery">
        <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="Drop files here">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            <div class="qq-upload-button-selector qq-upload-button">
                <div>Upload a file</div>
            </div>
            <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing dropped files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
            <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite" aria-relevant="additions removals">
                <li>
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                    <div class="qq-progress-bar-container-selector qq-progress-bar-container">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <div class="qq-thumbnail-wrapper">
                        <img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale>
                    </div>
                    <button type="button" class="qq-upload-cancel-selector qq-upload-cancel">X</button>
                    <button type="button" class="qq-upload-retry-selector qq-upload-retry">
                        <span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
                        Retry
                    </button>

                    <div class="qq-file-info">
                        <div class="qq-file-name">
                            <span class="qq-upload-file-selector qq-upload-file"></span>
                            <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
                        </div>
                        <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                        <span class="qq-upload-size-selector qq-upload-size"></span>
                        <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">
                            <span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
                            <span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
                            <span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
                        </button>
                    </div>
                </li>
            </ul>

            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Close</button>
                </div>
            </dialog>

            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">No</button>
                    <button type="button" class="qq-ok-button-selector">Yes</button>
                </div>
            </dialog>

            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cancel</button>
                    <button type="button" class="qq-ok-button-selector">Ok</button>
                </div>
            </dialog>
        </div>
    </script>

    <script>
        var galleryUploader = new qq.FineUploader({
            element: document.getElementById("fine-uploader-gallery"),
            template: 'qq-template-gallery',
            request: {
                endpoint: '/management/articles/uploadImage',
                customHeaders: {
                    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                },
                params: {
                    'articleId': '{{ $article->getId() }}'
                }
            },
            thumbnails: {
                placeholders: {
                    waitingPath: '/source/placeholders/waiting-generic.png',
                    notAvailablePath: '/source/placeholders/not_available-generic.png'
                }
            },
            validation: {
                allowedExtensions: ['jpeg', 'jpg', 'gif', 'png']
            }
        });
    </script>
@endsection