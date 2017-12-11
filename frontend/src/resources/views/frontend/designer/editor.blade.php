@extends('frontend.layouts.app')

@section('content')
    <section id="papel-comestible">
        <div class="container">
            <div class="row">
                <br>
                <div class="col-lg-12 text-center">
                    <h2>Papel comestible A4 - Diseño libre</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row" style="text-align: center">
                <div class="col-md-2" style="width: 235px;">
                    <h3>herramientas</h3>
                    <div class="btn-group-vertical btn-block">
                        <button data-target="#tools-text" type="button" class="btn btn-lg btn-primary" id="add-text">Agregar
                            Texto
                        </button>

                        <div style="height:0px;overflow:hidden">
                            <input type="file" id="imageInput" name="imageInput"/>
                        </div>
                        <button data-target="#tools-image" type="button" class="btn btn-lg btn-primary" id="add-image">
                            Agregar Imagen
                        </button>
                    </div>
                    <h3>Propiedades</h3>
                    <div id="canvas-tools">
                        <div class="form-group">
                            <label for="canvas-color">Color de fondo:</label>
                            <input type="text" id="canvas-color" class="form-control" value="#ffffff">
                        </div>
                    </div>
                    <h3>Capas</h3>
                    <div id="layers">
                        <span id="no-layer">Cuando agregue texto o imagenes apareceran aquí</span>
                        <div class="list-group" id="container-layers">
                        </div>

                        <button type="button" class="btn btn-xs btn-primary" id="deselect-all" style="display:none">
                            Deseleccionar todas
                        </button>
                    </div>
                    <br>
                    <div>
                        <div class="btn-group-vertical btn-block">
                            <button type="button" class="btn btn-lg btn-info" id="save-image">Guardar como imagen</button>
                            <button type="button" class="btn btn-lg btn-warning" id="save-svg">Guardar como SVG</button>
                            <button type="button" class="btn btn-lg btn-danger" id="save-json">JSON</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-7" style="position:relative;">
                    <div class="canvas-container">
                        <canvas class="canvas-paper-a4" id="canvas-paper-a4" width="3124" height="3124" style="width:600px;height:600px;"></canvas>
                    </div>
                    <span data-toggle="popover" data-placement="right" data-content="Ingrese el texto"></span>
                </div>

                <div class="col-md-2">
                    <div class="" id="text-tools" hidden>
                        <div id="text-controls">
                            <div class="form-group">
                                <label for="text">Texto:</label>
                                <textarea rows="2" class="form-control" id="text"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="text-color">Color:</label>
                                <input type="text" id="text-color" class="form-control" value="#70c24a">
                            </div>
                            <div class="form-group">
                                <label for="text-font">Fuente:</label>
                                <select class="form-control" id="text-font">
                                    <option value="Arial" class="Arial">Arial</option>
                                    <option value="Courier" class="Courier">Courier</option>
                                    <option value="Comic Sans MS" class="ComicSansMS">Cairo</option>
                                    <option style="font-family: 'Fascinate Inline' !important;">Courgette</option>
                                </select>
                            </div>
                            <!--<div class="form-group">-->
                            <!--<label for="text-line-height">Altura de la línea:</label>-->
                            <!--<input type="range" value="" min="1" max="12" step="0.025" id="text-line-height">-->
                            <!--</div>-->
                            <div class="form-group">
                                <label>Alineación:</label><br>
                                <button class="btn-primary btn-xs" id="btn-align-left"><i class="fa fa-align-left" data-toggle="tooltip" title="Alinear a la izquierda"></i></button>
                                <button class="btn-primary btn-xs" id="btn-align-center"><i class="fa fa-align-center" data-toggle="tooltip" title="Centrar"></i>
                                </button>
                                <button class="btn-primary btn-xs" id="btn-align-right"><i class="fa fa-align-right" data-toggle="tooltip" title="Alinear a la derecha"></i></button>
                            </div>
                            <div class="form-group">
                                <label>Estilo:</label><br>
                                <button class="btn-primary btn-xs" id="btn-bold" data-toggle="tooltip" title="Negrita"><i class="fa fa-bold"></i></button>
                                <button class="btn-primary btn-xs" id="btn-italic" data-toggle="tooltip" title="Cursiva"><i class="fa fa-italic"></i></button>
                                <button class="btn-primary btn-xs" id="btn-underline"><i class="fa fa-underline" data-toggle="tooltip" title="Subrayado"></i></button>
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
                            <button class="btn-primary btn-xs" id="btn-center-vertically" data-toggle="tooltip" title="Centrar verticalmente"><i class="fa fa-compress fa-rotate--45"></i></button>
                            <button class="btn-primary btn-xs" id="btn-center-horizontally" data-toggle="tooltip" title="Centrar horizontalmente"><i class="fa fa-compress fa-rotate-45"></i></button>
                            <button class="btn-primary btn-xs" id="btn-flip-vertically" data-toggle="tooltip" title="Voltear verticalmente"><i class="fa fa-arrow-up"></i></button>
                            <button class="btn-primary btn-xs" id="btn-flip-horizontally" data-toggle="tooltip" title="Voltear horizontalmente"><i class="fa fa-arrow-right"></i></button>
                        </div>
                        <div class="form-group">
                            <label><input type="checkbox" name="block" id="block">Bloquear</label>
                        </div>
                    </div>
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
    <script src="/editor-assets/js/designer.js">
@endsection