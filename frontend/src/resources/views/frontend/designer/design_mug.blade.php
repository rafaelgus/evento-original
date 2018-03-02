@extends('frontend.layouts.app')

@section('scripts_header')
    <style>
        /*.canvas-container {*/
        /*background-color: #EBEBEB;*/
        /*text-align: center;*/
        /*margin: 0px auto;*/
        /*width: 100%;*/
        /*height: 700px;*/
        /*}*/

        /*.canvas-paper-a4 {*/
        /*margin-top: 50px;*/
        /*}*/

        .fa-rotate-45 {
            -webkit-transform: rotate(45deg);
            -moz-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            -o-transform: rotate(45deg);
            transform: rotate(45deg);
        }

        .fa-rotate--45 {
            -webkit-transform: rotate(-45deg);
            -moz-transform: rotate(-45deg);
            -ms-transform: rotate(-45deg);
            -o-transform: rotate(-45deg);
            transform: rotate(-45deg);
        }

        .popover {
            background: #2C3E50 !important;
        }

        .popover-content {
            color: white;
        }

        .popover.right .arrow:after {
            border-right-color: #2C3E50;
        }

        .canvas-container {
            padding-bottom: 1rem;
        }

        .detail-select {
            width: 100%;
            border-radius: 5px;
            border-color: initial;
            margin: 1rem 0;
        }

        .mySlides {
            width: 40%;
            margin-bottom: 3px !important;
        }

    </style>

    <!-- Custom Fonts -->

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/jquery-minicolors/2.2.6/jquery.minicolors.min.css"/>
    <link href="/editor-assets/css/bootstrap-tour.min.css" rel="stylesheet">
    <link href="/css/bootstrap-switch.min.css" rel="stylesheet">
    <link href="/css/icheck-flat/red.css" rel="stylesheet">
    <link rel="stylesheet" href="/editor-assets/css/fontselect-alternate.css">
@endsection

@section('content')
    <section class="editor" id="editor">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="title">{{ trans('designer.design_mug.title') }}</h2>
                </div>
            </div>
            <div class="row" style="text-align: center">
                <div class="col-md-5" style="position:relative; width: auto">
                    <div class="canvas-container">
                        <canvas class="canvas-paper-a4" id="canvas-paper-a4"></canvas>
                    </div>

                    <div class="w3-content w3-display-container">
                        <canvas class="mySlides" id="canvas1" style="margin: auto"></canvas>
                        <canvas class="mySlides" id="canvas2" style="margin: auto"></canvas>
                        <canvas class="mySlides" id="canvas3" style="margin: auto"></canvas>


                        <button class="w3-button w3-black" onclick="plusDivs(-1)">&#10094;</button>
                        <button class="w3-button w3-black" onclick="plusDivs(1)">&#10095;</button>
                    </div>
                    {{--<span data-toggle="popover" data-placement="right" data-content="Ingrese el texto"></span>--}}
                </div>

                <div class="col-md-5 editor-tools" id="editor-tools">
                    <div id="canvas-tools" class="canvas-tools">
                        <div class="form-group row">
                            <label for="canvas-color"
                                   class="col-sm-4 col-form-label">{{ trans('editor.background_color') }}:</label>

                            <div class="col-sm-8">
                                <input type="text" id="canvas-color" class="form-control" value="#ffffff">
                            </div>
                        </div>

                        <button data-target="#tools-text" type="button" class="btn btn-lg btn-primary add-button"
                                id="add-text">
                            <i class="fa fa-pencil"></i> {{ trans('editor.add_text') }}
                        </button>

                        <div style="height:0px;overflow:hidden">
                            <input type="file" id="imageInput" name="imageInput"/>
                        </div>

                        <button data-target="#tools-image" type="button" class="btn btn-lg btn-primary add-button"
                                id="add-image">
                            <i class="fa fa-camera"></i> {{ trans('editor.add_image') }}
                        </button>

                        <hr>


                        <div class="add-to-box text-center">
                            <div class="add-to-cart">
                                <div class="form-group row">
                                    <br>
                                    <div class="col-sm-12">
                                        <form role="form" id="save-design-form" class="form-horizontal"
                                              action="{{ route('save_design') }}" enctype="multipart/form-data"
                                              method="POST">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="json" id="json" value="">
                                            <input type="hidden" name="variant_id"
                                                   value="mug">
                                            <input type="hidden" name="image" id="image-file">
                                            <input type="hidden" name="design_id" id="design_id"
                                                   value="{{ (isset($design) ? $design->getId() : null) }}">
                                            <button class="button btn-cart" id="save-design"
                                                    title="{{ trans('designer.save') }}"
                                                    type="button">{{ trans('designer.save') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="add-to-box text-center">
                            <div class="add-to-cart">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <form role="form" id="finalize-design-form" class="form-horizontal"
                                              action="{{ route('finalize_design') }}" enctype="multipart/form-data"
                                              method="POST">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="json" id="json" value="">
                                            <input type="hidden" name="variant_id"
                                                   value="mug">
                                            <input type="hidden" name="image" id="image-file">
                                            <input type="hidden" name="design_id" id="design_id"
                                                   value="{{ (isset($design) ? $design->getId() : null) }}">
                                            <button class="button btn-cart btn-violet" id="finalize-design"
                                                    title="{{ trans('designer.finalize') }}"
                                                    type="button">{{ trans('designer.finalize') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="text-tools" id="text-tools" hidden>
                        <h2 class="tools-title">{{ trans('editor.add_text') }}</h2>

                        <div id="text-controls">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <textarea rows="3" class="form-control" id="text"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="text-color" class="col-sm-4 col-form-label">{{ trans('editor.color') }}
                                    :</label>
                                <div class="col-sm-8">
                                    <input type="text" id="text-color" class="form-control" value="#70c24a">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="text-font" class="col-sm-4 col-form-label">{{ trans('editor.font') }}
                                    :</label>
                                <div class="col-sm-8">
                                    <input type="text" id="fonts">
                                    {{--<select class="form-control" id="text-font">--}}
                                    {{--<option value="Arial" class="Arial">Arial</option>--}}
                                    {{--<option value="Courier" class="Courier">Courier</option>--}}
                                    {{--<option value="Comic Sans MS" class="ComicSansMS">Cairo</option>--}}
                                    {{--<option style="font-family: 'Fascinate Inline' !important;">Courgette</option>--}}
                                    {{--</select>--}}
                                </div>
                            </div>
                            <div class="form-group row other-text-tools">
                                <div class="col-sm-12">
                                    <button class="btn-primary btn-xs" id="btn-align-left"><i class="fa fa-align-left"
                                                                                              data-toggle="tooltip"
                                                                                              title="{{ trans('editor.align_left') }}"></i>
                                    </button>
                                    <button class="btn-primary btn-xs" id="btn-align-center"><i
                                                class="fa fa-align-center"
                                                data-toggle="tooltip"
                                                title="{{ trans('editor.align_center') }}"></i>
                                    </button>
                                    <button class="btn-primary btn-xs" id="btn-align-right"><i class="fa fa-align-right"
                                                                                               data-toggle="tooltip"
                                                                                               title="{{ trans('editor.align_right') }}"></i>
                                    </button>
                                    <button class="btn-primary btn-xs" id="btn-bold" data-toggle="tooltip"
                                            title="{{ trans('editor.bold') }}">
                                        <i class="fa fa-bold"></i></button>
                                    <button class="btn-primary btn-xs" id="btn-italic" data-toggle="tooltip"
                                            title="{{ trans('editor.italic') }}"><i class="fa fa-italic"></i></button>
                                    <button class="btn-primary btn-xs" id="btn-underline"><i class="fa fa-underline"
                                                                                             data-toggle="tooltip"
                                                                                             title="{{ trans('editor.underline') }}"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="checkbox" name="text-curved" id="text-curved"><label
                                        class="label-form">{{ trans('editor.curved_text') }}</label>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6" id="input-radius" style="display: none;">
                                    <label for="scale">{{ trans('editor.radius') }}:</label>
                                    <input type="range" min="0" max="250" id="radius">
                                </div>
                                <div class="form-group col-md-6" id="input-spacing" style="display: none">
                                    <label for="scale">{{ trans('editor.spacing') }}:</label>
                                    <input type="range" min="1" max="30" id="spacing">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="image-tools" hidden>
                        <div class="form-group">
                            <div style="height:0px;overflow:hidden">
                                <input type="file" id="changeImageInput" name="changeImageInput"/>
                            </div>
                            <button data-target="#tools-image" type="button" class="btn btn-primary btn-change-image"
                                    id="change-image">
                                {{ trans('editor.change_image') }}
                            </button>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" id="remove-white"><label
                                    class="label-form">{{ trans('editor.remove_white') }}</label>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button class="btn btn-primary btn-black-and-white"
                                        id="grayscale">{{ trans('editor.grayscale') }}</button>
                                <button class="btn btn-primary btn-sepia" id="sepia">Sepia</button>
                                <button class="btn btn-primary btn-sepia2" id="sepia2">Sepia2</button>
                            </div>
                        </div>

                        <div class="form-group row" id="input-brightness">
                            <label for="brightness-value" class="col-sm-4">{{ trans('editor.brightness') }}</label>
                            <div class="col-sm-8">
                                <input type="range" min="-50" max="50" value="0" id="brightness-value">
                            </div>
                        </div>

                        <div class="form-group row" id="input-contrast">
                            <label for="contrast-value" class="col-sm-4">{{ trans('editor.contrast') }}</label>
                            <div class="col-sm-8">
                                <input type="range" min="-100" max="100" value="0" id="contrast-value">
                            </div>
                        </div>

                        <div class="form-group row" id="input-saturation">
                            <label for="saturation-value" class="col-sm-4">{{ trans('editor.saturation') }}</label>
                            <div class="col-sm-8">
                                <input type="range" min="-100" max="100" value="0" id="saturation-value">
                            </div>
                        </div>

                        <div class="form-group row" id="input-pixelate">
                            <label for="pixelate-value" class="col-sm-4">{{ trans('editor.pixelate') }}</label>
                            <div class="col-sm-8">
                                <input type="range" min="1" max="10" step="1" value="1" id="pixelate-value">
                            </div>
                        </div>
                    </div>
                    <div class="common-tools" id="common-tools" hidden>
                        <hr>
                        <div class="form-group row">
                            <label for="scale" class="col-sm-4 col-form-label">{{ trans('editor.size') }}:</label>
                            <div class="col-sm-8 text-left">
                                <button class="btn-primary btn-xs icon-button" id="btn-decrease-size"
                                        data-toggle="tooltip"
                                        title="{{ trans('editor.decrease_size') }}"><i
                                            class="fa fa-minus"></i></button>
                                <button class="btn-primary btn-xs icon-button" id="btn-increase-size"
                                        data-toggle="tooltip"
                                        title="{{ trans('editor.increase_size') }}"><i
                                            class="fa fa-plus"></i></button>
                                {{--<input type="range" value="" min="0.1" max="10" step="0.1" id="scale">--}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="scale" class="col-sm-4 col-form-label">{{ trans('editor.rotate') }}:</label>

                            <div class="col-sm-8 text-left">
                                <button class="btn-primary btn-xs icon-button" id="btn-rotate-left"
                                        data-toggle="tooltip"
                                        title="{{ trans('editor.rotate_left') }}"><i
                                            class="fa fa-rotate-left"></i></button>
                                <button class="btn-primary btn-xs icon-button" id="btn-rotate-right"
                                        data-toggle="tooltip"
                                        title="{{ trans('editor.rotate_right') }}"><i
                                            class="fa fa-rotate-right"></i></button>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn-primary btn-xs icon-button"
                                    id="btn-to-back">{{ trans('editor.to_back') }}</button>
                            <button class="btn-primary btn-xs icon-button"
                                    id="btn-to-front">{{ trans('editor.to_front') }}</button>
                            <button class="btn-primary btn-xs icon-button" id="btn-center-vertically"
                                    data-toggle="tooltip"
                                    title="{{ trans('editor.center_vertically') }}"><i
                                        class="fa fa-compress fa-rotate--45"></i></button>
                            <button class="btn-primary btn-xs icon-button" id="btn-center-horizontally"
                                    data-toggle="tooltip"
                                    title="{{ trans('editor.center_horizontally') }}"><i
                                        class="fa fa-compress fa-rotate-45"></i></button>
                            <button class="btn-primary btn-xs icon-button" id="btn-flip-vertically"
                                    data-toggle="tooltip"
                                    title="{{ trans('editor.flip_vertically') }}"><i class="fa fa-arrow-up"></i>
                            </button>
                            <button class="btn-primary btn-xs icon-button" id="btn-flip-horizontally"
                                    data-toggle="tooltip"
                                    title="{{ trans('editor.flip_horizontally') }}"><i class="fa fa-arrow-right"></i>
                            </button>
                        </div>
                        {{--<div class="form-group">--}}
                        {{--<input type="checkbox" name="block" id="block"><label--}}
                        {{--class="label-form">{{ trans('editor.block') }}</label>--}}
                        {{--</div>--}}

                        <button type="button" id="finalize-edit-text-button"
                                class="btn btn-lg btn-primary finalize-button">{{ trans('editor.finalize_edit_text') }}</button>

                        <button type="button" id="finalize-edit-image-button"
                                class="btn btn-lg btn-primary finalize-button">{{ trans('editor.finalize_edit_image') }}</button>

                        {{--<button class="btn btn-primary btn-remove-object" id="btn-remove-object">--}}
                        {{--<i class="fa fa-trash"></i>--}}
                        {{--{{ trans('editor.remove') }}--}}
                        {{--</button>--}}
                    </div>
                </div>

                {{--<h3>Capas</h3>--}}
                {{--<div id="layers">--}}
                {{--<span id="no-layer">Cuando agregue texto o imagenes apareceran aquí</span>--}}
                {{--<div class="list-group" id="container-layers">--}}
                {{--</div>--}}

                {{--<button type="button" class="btn btn-xs btn-primary" id="deselect-all" style="display:none">--}}
                {{--Deseleccionar todas--}}
                {{--</button>--}}
                {{--</div>--}}
                {{--<br>--}}
                {{--<div>--}}
                {{--<div class="btn-group-vertical btn-block">--}}
                {{--<button type="button" class="btn btn-lg btn-info" id="save-image">Guardar como imagen--}}
                {{--</button>--}}
                {{--<button type="button" class="btn btn-lg btn-warning" id="save-svg">Guardar como SVG</button>--}}
                {{--<button type="button" class="btn btn-lg btn-danger" id="save-json">JSON</button>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<br>--}}
            </div>

            <div class="col-md-2">
            </div>
        </div>
        </div>
    </section>
@endsection

@section('scripts_body')
    <script src="/editor-assets/js/fabric.js"></script>
    <script src="/editor-assets/js/customiseControls.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-minicolors/2.2.6/jquery.minicolors.js"></script>

    <script src="/editor-assets/js/FileSaver.min.js"></script>
    <script src="/editor-assets/js/canvas-to-blob.min.js"></script>
    <script src="/editor-assets/js/fabric.curvedText.js"></script>
    <script src="/editor-assets/js/designer.js"></script>

    <script src="/editor-assets/js/bootstrap-tour.min.js"></script>
    <script src="/js/bootstrap-switch.min.js"></script>
    <script src="/js/icheck.min.js"></script>
    <script src="/editor-assets/js/jquery.fontselect.min.js"></script>

    <script>
        var canvasHeight = 300;
        var canvasWidth = 600;
        var overlayImage = '';

        var designJson = '{{ (isset($design) ? $design->getJson() : null) }}';
        if (designJson) {
            designJson = JSON.parse(designJson.replace(/&quot;/g, '"'));
        }

        $(document).ready(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_flat-red',
                radioClass: 'iradio_flat-red'
            });
            $('input').on('ifChanged', function(event) {
                $(event.target).trigger('change');
            });

            $('[data-toggle="tooltip"]').tooltip();

            // Instance the tour
            var tour = new Tour({
                name: 'tour1',
                steps: [
                    {
                        element: "#add-text",
                        title: "Agregar Texto",
                        content: "Haga click aquí si desea agregar un texto al diseño."
                    },
                    {
                        element: "#add-image",
                        title: "Agregar imagen",
                        content: "Si desea agregar una imagen haga click aquí."
                    },
                    {
                        element: "#canvas-tools",
                        title: "Color de fondo",
                        content: "Seleccione el color de fondo del diseño."
                    },
                    {
                        element: "#layers",
                        title: "Capas",
                        content: "Gestione las capas del diseño seleccionando una de ellas."
                    }
                ],
                template: "<div class='popover tour'><div class='arrow'></div> <h3 class='popover-title'></h3> <div class='popover-content'></div> <div class='popover-navigation'> <button class='btn btn-default btn-sm' data-role='prev'>« Ant</button> <span data-role='separator'>|</span> <button class='btn btn-default btn-sm' data-role='next'>Sig »</button>  <button class='btn btn-default btn-sm' data-role='end' style='margin-left: 5px'>Cerrar</button> </div> </div>"
            });

            tour.init();

            tour.start();

            $('#fonts').fontselect({
                style: 'font-select',
                placeholder: 'Select a font',
                lookahead: 2
            });



            function canvas1() {
                var mugCanvas = document.getElementById("canvas-paper-a4");
                var mugImg = mugCanvas.toDataURL("image/png");

                var canvas = document.getElementById("canvas1");
                var ctx = canvas.getContext("2d");

                var productImg = new Image();
                productImg.onload = function() {
                    var iw = productImg.width;
                    var ih = productImg.height;
                    console.log("height");

                    canvas.width = iw;
                    canvas.height = ih;

                    ctx.drawImage(productImg, 0, 0, productImg.width, productImg.height,
                        0, 0, iw, ih);
                    loadUpperIMage()
                };

                productImg.src = "http://res.cloudinary.com/pussyhunter/image/upload/c_scale,f_auto,h_350/left_handle_cup_i7ztfs.jpg"


                function loadUpperIMage() {
                    var img = new Image();

                    img.src = mugImg;
                    img.onload = function() {

                        var iw = img.width;
                        var ih = img.height;

                        var xOffset = 102, //left padding
                            yOffset = 110; //top padding

                        //alert(ih)
                        var a = 75.0; //image width
                        var b = 10; //round ness

                        var scaleFactor = iw / (4 * a);

                        // draw vertical slices
                        for (var X = 0; X < iw; X += 1) {
                            var y = b / a * Math.sqrt(a * a - (X - a) * (X - a)); // ellipsis equation
                            ctx.drawImage(img, X * scaleFactor, 0, iw / 9, ih, X + xOffset, y + yOffset, 1, 174);
                        }
                    };
                }

            }

            function canvas2() {
                var mugCanvas = document.getElementById("canvas-paper-a4");
                var mugImg = mugCanvas.toDataURL("image/png");

                var canvas = document.getElementById("canvas2");
                var ctx = canvas.getContext("2d");

                var productImg = new Image();
                productImg.onload = function() {
                    var iw = productImg.width;
                    var ih = productImg.height;

                    canvas.width = iw;
                    canvas.height = ih;

                    ctx.drawImage(productImg, 0, 0, productImg.width, productImg.height,
                        0, 0, iw, ih);
                    loadUpperIMage()
                };


                productImg.src = "http://res.cloudinary.com/pussyhunter/image/upload/h_350/canter_handle_cup_xyxhdd.jpg"

                function loadUpperIMage() {
                    var img = new Image();

                    img.src = mugImg;
                    img.onload = function() {

                        var iw = img.width;
                        var ih = img.height;

                        // alert(iw)

                        var xOffset = 101, //left padding
                            yOffset = 110; //top padding

                        var a = 75.0; //image width
                        var b = 10; //round ness

                        var scaleFactor = iw / (4 * a);

                        // draw vertical slices
                        for (var X = 0; X < iw; X += 1) {
                            var y = b / a * Math.sqrt(a * a - (X - a) * (X - a)); // ellipsis equation
                            ctx.drawImage(img, X * scaleFactor, 0, iw / 3, ih, X + xOffset, y + yOffset, 1, 174);

                        }
                    };
                }

            }

            function canvas3() {
                var mugCanvas = document.getElementById("canvas-paper-a4");
                var mugImg = mugCanvas.toDataURL("image/png");

                var canvas = document.getElementById("canvas3");
                var ctx = canvas.getContext("2d");

                var productImg = new Image();
                productImg.onload = function() {
                    var iw = productImg.width;
                    var ih = productImg.height;

                    canvas.width = iw;
                    canvas.height = ih;

                    ctx.drawImage(productImg, 0, 0, productImg.width, productImg.height,
                        0, 0, iw, ih);
                    loadUpperIMage()
                };

                productImg.src = "http://res.cloudinary.com/pussyhunter/image/upload/h_350/right_handle_cup_dsdhr7.jpg"


                function loadUpperIMage() {
                    var img = new Image();

                    img.src = mugImg;
                    img.onload = function() {

                        var iw = img.width;
                        var ih = img.height;

                        //alert(iw)

                        var xOffset = 102, //left padding
                            yOffset = 110; //top padding

                        var a = 75.0; //image width
                        var b = 10; //round ness

                        var scaleFactor = iw / (3 * a);

                        // draw vertical slices
                        for (var X = 0; X < iw; X += 1) {
                            var y = b / a * Math.sqrt(a * a - (X - a) * (X - a)); // ellipsis equation
                            ctx.drawImage(img, X * scaleFactor, 0, iw / 1.5, ih, X + xOffset, y + yOffset, 1, 174);
                        }
                    };
                }

            }

            setTimeout(function() {
                canvas1()
            }, 1000);
            setTimeout(function() {
                canvas2()
            }, 2000);
            setTimeout(function() {
                canvas3()
            }, 3000);

            setInterval(canvas1, 1000);
            setInterval(canvas2, 1000);
            setInterval(canvas3, 1000);
        });

        var slideIndex = 1;
        showDivs(slideIndex);

        function plusDivs(n) {
            showDivs(slideIndex += n);
        }

        function showDivs(n) {
            var i;
            var x = document.getElementsByClassName("mySlides");
            if (n > x.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = x.length
            }
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            x[slideIndex - 1].style.display = "block";
        }

    </script>
@endsection
