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
    </style>

    <!-- Custom Fonts -->

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/jquery-minicolors/2.2.6/jquery.minicolors.min.css"/>
    <link href="/editor-assets/css/bootstrap-tour.min.css" rel="stylesheet">
@endsection

@section('content')
    <section class="editor" id="editor">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="title">Papel Comestible A4</h2>
                </div>
            </div>
            <div class="row" style="text-align: center">
                <div class="col-md-1"></div>
                <div class="col-md-5" style="position:relative;">
                    <div class="canvas-container">
                        <canvas class="canvas-paper-a4" id="canvas-paper-a4"></canvas>
                    </div>
                    {{--<span data-toggle="popover" data-placement="right" data-content="Ingrese el texto"></span>--}}
                </div>

                <div class="col-md-5 editor-tools">
                    <div id="canvas-tools" class="canvas-tools">
                        <div class="form-group row">
                            <label for="canvas-color" class="col-sm-4 col-form-label">{{ trans('editor.background_color') }}:</label>

                            <div class="col-sm-8">
                                <input type="text" id="canvas-color" class="form-control" value="#ffffff">
                            </div>
                        </div>

                        <button data-target="#tools-text" type="button" class="btn btn-lg btn-primary add-button" id="add-text">
                            <i class="fa fa-pencil"></i> {{ trans('editor.add_text') }}
                        </button>

                        <div style="height:0px;overflow:hidden">
                            <input type="file" id="imageInput" name="imageInput"/>
                        </div>

                        <button data-target="#tools-image" type="button" class="btn btn-lg btn-primary add-button" id="add-image">
                            <i class="fa fa-camera"></i> {{ trans('editor.add_image') }}
                        </button>
                    </div>

                    <div class="text-tools" id="text-tools" hidden>
                        <div id="text-controls">
                            <div class="form-group">
                                <textarea rows="3" class="form-control" id="text"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="text-color" class="col-sm-4 col-form-label">{{ trans('editor.color') }}:</label>
                                <div class="col-sm-8">
                                    <input type="text" id="text-color" class="form-control" value="#70c24a">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="text-font" class="col-sm-4 col-form-label">Fuente:</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="text-font">
                                        <option value="Arial" class="Arial">Arial</option>
                                        <option value="Courier" class="Courier">Courier</option>
                                        <option value="Comic Sans MS" class="ComicSansMS">Cairo</option>
                                        <option style="font-family: 'Fascinate Inline' !important;">Courgette</option>
                                    </select>
                                </div>
                            </div>
                            <!--<div class="form-group">-->
                            <!--<label for="text-line-height">Altura de la línea:</label>-->
                            <!--<input type="range" value="" min="1" max="12" step="0.025" id="text-line-height">-->
                            <!--</div>-->
                            <div class="form-group">
                                <label>Alineación:</label><br>
                                <button class="btn-primary btn-xs" id="btn-align-left"><i class="fa fa-align-left"
                                                                                          data-toggle="tooltip"
                                                                                          title="Alinear a la izquierda"></i>
                                </button>
                                <button class="btn-primary btn-xs" id="btn-align-center"><i class="fa fa-align-center"
                                                                                            data-toggle="tooltip"
                                                                                            title="Centrar"></i>
                                </button>
                                <button class="btn-primary btn-xs" id="btn-align-right"><i class="fa fa-align-right"
                                                                                           data-toggle="tooltip"
                                                                                           title="Alinear a la derecha"></i>
                                </button>
                            </div>
                            <div class="form-group">
                                <label>Estilo:</label><br>
                                <button class="btn-primary btn-xs" id="btn-bold" data-toggle="tooltip" title="Negrita">
                                    <i class="fa fa-bold"></i></button>
                                <button class="btn-primary btn-xs" id="btn-italic" data-toggle="tooltip"
                                        title="Cursiva"><i class="fa fa-italic"></i></button>
                                <button class="btn-primary btn-xs" id="btn-underline"><i class="fa fa-underline"
                                                                                         data-toggle="tooltip"
                                                                                         title="Subrayado"></i></button>
                            </div>
                            <div class="form-group">
                                <label><input type="checkbox" name="text-curved" id="text-curved">Texto Curvado</label>
                            </div>
                            <div class="form-group" id="input-radius" style="display: none;">
                                <label for="scale">Radio:</label>
                                <input type="range" min="0" max="250" id="radius">
                            </div>
                            <div class="form-group" id="input-spacing" style="display: none">
                                <label for="scale">Espaciado:</label>
                                <input type="range" min="1" max="20" id="spacing">
                            </div>
                        </div>
                    </div>

                    <div id="image-tools" hidden>
                        <div class="form-group">
                            <input type="checkbox" id="remove-white">Eliminar blancos
                        </div>
                        <div class="form-group" id="input-brightness">
                            <input type="checkbox" id="brightness"><label for="scale">Brillo:</label>
                            <input type="range" min="0" max="100" id="brightness-value">
                        </div>
                        <div class="form-group">
                            <div style="height:0px;overflow:hidden">
                                <input type="file" id="changeImageInput" name="changeImageInput"/>
                            </div>
                            <button data-target="#tools-image" type="button" class="btn btn-primary" id="change-image">
                                Cambiar Imagen
                            </button>
                        </div>
                    </div>
                    <div id="common-tools" hidden>
                        <hr>
                        <div class="form-group">
                            <label for="scale">Tamaño:</label>
                            <input type="range" value="" min="0" max="10" step="0.1" id="scale">
                        </div>
                        <div class="form-group">
                            <label>Mover:</label><br>
                            <button class="btn-primary btn-xs" id="btn-to-back">to back</button>
                            <button class="btn-primary btn-xs" id="btn-to-front">to front</button>
                            <br>
                            <button class="btn-primary btn-xs" id="btn-center-vertically" data-toggle="tooltip"
                                    title="Centrar verticalmente"><i class="fa fa-compress fa-rotate--45"></i></button>
                            <button class="btn-primary btn-xs" id="btn-center-horizontally" data-toggle="tooltip"
                                    title="Centrar horizontalmente"><i class="fa fa-compress fa-rotate-45"></i></button>
                            <button class="btn-primary btn-xs" id="btn-flip-vertically" data-toggle="tooltip"
                                    title="Voltear verticalmente"><i class="fa fa-arrow-up"></i></button>
                            <button class="btn-primary btn-xs" id="btn-flip-horizontally" data-toggle="tooltip"
                                    title="Voltear horizontalmente"><i class="fa fa-arrow-right"></i></button>
                        </div>
                        <div class="form-group">
                            <label><input type="checkbox" name="block" id="block">Bloquear</label>
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

                    {{--<form role="form" id="save-design-form" class="form-horizontal" action="{{ route('save_design') }}"--}}
                          {{--method="POST">--}}
                        {{--@include('backend.messages.session')--}}
                        {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                        {{--<input type="hidden" name="json" id="json" value="">--}}
                        {{--<div class="form-group">--}}
                            {{--<input type="text" class="form-control" id="name" name="name"--}}
                                   {{--placeholder="Nombre del diseño"/>--}}
                            {{--<button type="button" class="btn btn-lg btn-success form-control" id="save-design">--}}
                                {{--Guardar diseño--}}
                            {{--</button>--}}
                        {{--</div>--}}
                    {{--</form>--}}
                </div>

                <div class="col-md-1">
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

    <script>
        $(document).ready(function () {
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
        });
    </script>
@endsection
