@extends('frontend.layouts.app')

@section('scripts_header')
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.1/css/bootstrap-slider.min.css">

    <style>
        .category-products .products-grid {
            margin: 0 !important;
        }

        .preview-image {
            width: 20%;
        }

        .preview-image-container {
            text-align: center;
        }

        .slider.slider-horizontal {
            display: block !important;
        }

        .price-value {
            font-weight: bold !important;
        }

        .earn-value {
            font-weight: bold !important;
        }
    </style>

    <link href="/backend/plugins/select2/select2.min.css" rel="stylesheet" type="text/css"/>
@stop

@section('content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul>
                        <li class="home"><a href="/" title="Go to Home Page">{{ trans('designer.title') }}</a>
                            <span>/</span></li>
                        <li class="category1601"><strong>{{ trans('designer.send_to_review.title') }}</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumbs End -->

    <!-- Main Container -->
    <section class="main-container col2-left-layout bounceInUp animated">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="category-description std">
                        <div class="slider-items-products">
                            <h2 class="page-heading"><span
                                        class="page-heading-title">{{ trans('designer.send_to_review.title') }}</span>
                            </h2>
                            <p class="category-description">
                                {{ trans('designer.send_to_review.description_title') }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <div class="preview-image-container">
                            <img class="preview-image" alt="{{ $design->getName() }}" src="{{ $design->getImage() }}"/>
                        </div>

                        <form class="form-list" role="form" method="POST" enctype="multipart/form-data"
                              action="{{ route('designer.sendDesignToReview', $design->getId()) }}">
                            {{ csrf_field() }}

                            @if($design->getSource() === \EventoOriginal\Core\Enums\DesignSource::TEMPLATE)
                                <div class="col-md-12 form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="image"
                                           class="control-label">{{ trans('designer.send_to_review.image') }}</label>

                                    <input id="image" type="file" class="form-control" name="image"
                                           value="{{ old('image') }}" required autofocus
                                           placeholder="{{ trans('designer.send_to_review.name_placeholder') }}">

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            @endif

                            <div class="col-md-12 form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name"
                                       class="control-label">{{ trans('designer.send_to_review.name') }}</label>

                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"
                                       required autofocus
                                       placeholder="{{ trans('designer.send_to_review.name_placeholder') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description"
                                       class="control-label">{{ trans('designer.send_to_review.description') }}</label>

                                <textarea id="description" type="text" class="form-control" name="description"
                                          required
                                          placeholder="{{ trans('designer.send_to_review.description_placeholder') }}"
                                          rows="4">{{ old('description') }}</textarea>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group{{ $errors->has('occasions') ? ' has-error' : '' }}">
                                <label for="inputOccasion"
                                       class="control-label">{{ trans('designer.send_to_review.occasions') }}</label>

                                <select id="inputOccasion" name="occasions[]" multiple="multiple" class="form-control">
                                    <option></option>
                                    @foreach($occasions as $occasion)
                                        <option value="{{ $occasion->getId() }}">{{ $occasion->getParent()->getName() }}
                                            - {{ $occasion->getName() }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('occasions'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('occasions') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group{{ $errors->has('commission') ? ' has-error' : '' }}">
                                <label for="commission"
                                       class="control-label">{{ trans('designer.send_to_review.commission') }}: </label>

                                <input type="text" value="5%" id="commission-value" readonly
                                       style="border:0; color:#f6931f; font-weight:bold;">

                                <input id="commission" type="text" name="commission" class="form-control" value=""
                                       data-slider-min="5"
                                       data-slider-max="40" data-slider-step="1"
                                       data-slider-value="5"/>

                                <div>
                                    <i>Precio: </i><label class="price-value"></label>
                                </div>

                                <div>
                                    <i>Lo que ganarás: </i><label class="earn-value">5.4 $</label>
                                </div>

                                @if ($errors->has('commission'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('commission') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <p>
                                    <a href="{{ route('terms_and_conditions') }}">{{ trans('designer.send_to_review.accept_terms') }}</a>
                                </p>
                            </div>

                            <div class="col-md-12 form-group">
                                <button type="submit" class="button login">
                                    {{ trans('designer.send_to_review.send') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Main Container End -->
@endsection

@section('scripts_body')
    <script src="/backend/plugins/select2/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.1/bootstrap-slider.min.js"></script>

    <script>
        $(document).ready(function() {
            var filename = '{{ $templateImage }}';

            if (filename) {
                var a = document.createElement('a');
                a.href = filename;
                a.download = filename;
                a.style.display = 'none';
                document.body.appendChild(a);
                a.click();
            }

            $("#commission").slider({}).on('slide', function() {
                var commissionValue = $('#commission').slider('getValue');

                maxPrice = (originalPrice + (originalPrice * (commissionValue / 100))).toFixed(2);
                earn = (maxPrice - originalPrice).toFixed(2);

                $('.price-value').text(maxPrice + " €");
                $('.earn-value').text(earn + " €");
                $("#commission-value").val(commissionValue + "%");
            });

            var commissionValue = parseInt($('#commission').slider('getValue'));
            var originalPrice = parseInt("{{ $maxPrice  / 100}}");


            var maxPrice = originalPrice + (originalPrice * (commissionValue / 100));
            var earn = (maxPrice - originalPrice).toFixed(2);

            $('.price-value').text(maxPrice + " €");
            $('.earn-value').text(earn + " €");

            $("#inputOccasion").select2({
                placeholder: "{{ trans('designer.send_to_review.select_occasion') }}"
            });
        });
    </script>
@stop