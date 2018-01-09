$('#add-image').click(function() {
    $('#imageInput').click();
});

$('#change-image').click(function() {
    $('#changeImageInput').click();
});

var canvas;
var id = 1;

$(document).ready(function() {
    canvas = new fabric.Canvas('canvas-paper-a4', {
        hoverCursor: 'pointer',
        selection: false,
        selectionBorderColor: 'blue',
        backgroundColor: 'white',
        borderColor: 'black',
        controlsAboveOverlay: true
    });

    fabric.Object.prototype.setControlsVisibility({
        ml: false,
        mr: false,
        mb: false,
        mtr: false,
        mt: false,
        br: true
    });

    canvas.setOverlayImage(
        '../editor-assets/bob constructor2.png',
        canvas.renderAll.bind(canvas),
        {
            width: canvas.width,
            height: canvas.height
        }
    );

    var customizeControlsOptions = {
        settings: {
            borderColor: '#413C5E',
            cornerSize: 25,
            cornerShape: 'rect',
            cornerBackgroundColor: '#e94d65',
            cornerPadding: 10
        },
        bl: {
            icon: '../editor-assets/icons/remove.svg'
        },
        tr: {
            icon: '../editor-assets/icons/resize.svg'
        },
        tl: {
            icon: '../editor-assets/icons/rotate.svg'
        },
        br: {
            icon: '../editor-assets/icons/copy-content.svg'
        }
    };

    // fabric.Object.prototype.customiseCornerIcons({
    //     settings: {
    //         borderColor: '#0094dd',
    //         cornerSize: 25,
    //         cornerShape: 'rect'
    //     },
    //     tr: {
    //         icon: '../editor-assets/icons/remove.svg'
    //     },
    //     br: {
    //         icon: '../editor-assets/icons/resize.svg'
    //     },
    //     mt: {
    //         icon: '../editor-assets/icons/rotate.svg'
    //     }
    // }, function () {
    //     canvas.renderAll();
    // });

    fabric.Canvas.prototype.customiseControls({
        bl: {
            action: function() {
                var selectedObject = canvas.getActiveObject();

                setTimeout(function() {
                    selectedObject.visible = false;

                    canvas.remove(selectedObject);
                    canvas.renderAll();
                }, 100);
            },
            cursor: 'pointer'
        },
        tr: {
            action: 'scale'
        },
        tl: {
            action: 'rotate',
            cursor: 'pointer'
        },
        br: {
            action: function() {
                var selectedObject = canvas.getActiveObject();

                selectedObject.clone(function(cloned) {
                    cloned.set('top', cloned.top + 15);
                    cloned.set('left', cloned.left + 15);
                    cloned.set("id", id);

                    setTimeout(function() {
                        cloned.customiseCornerIcons(customizeControlsOptions, function() {
                            canvas.renderAll();
                        });

                        canvas.add(cloned);

                        canvas.setActiveObject(cloned);
                    }, 100);

                    id++;
                });
            },
            cursor: 'pointer'
        }
    });

    canvas.on({
        'object:moving': function(e) {
            e.target.opacity = 0.5;
        },
        'object:modified': function(e) {
            e.target.opacity = 1;
        },
        'object:selected': onObjectSelected,
        'object:removed': onObjectRemoved,
        'selection:cleared': onSelectedCleared
    });

    var _prevActive = 0;
    var _layer = 0;

    fabric.util.addListener(canvas.upperCanvasEl, "dblclick", function(e) {
        var _canvas = canvas;
        //current mouse position
        var _mouse = _canvas.getPointer(e);
        //active object (that has been selected on click)
        var _active = _canvas.getActiveObject();
        //possible dblclick targets (objects that share mousepointer)
        var _targets = _canvas.getObjects().filter(function(_obj) {
            return _obj.containsPoint(_mouse) && !_canvas.isTargetTransparent(_obj, _mouse.x, _mouse.y);
        });

        _canvas.deactivateAll();

        //new top layer target
        if (_prevActive !== _active) {
            //try to go one layer below current target
            _layer = Math.max(_targets.length - 2, 0);
        }
        //top layer target is same as before
        else {
            //try to go one more layer down
            _layer = --_layer < 0 ? Math.max(_targets.length - 2, 0) : _layer;
        }

        //get obj on current layer
        var _obj = _targets[_layer];

        if (_obj && _obj.selectable) {
            _prevActive = _obj;
            // _obj.bringToFront();
            _canvas.setActiveObject(_obj).renderAll();
        }
    });

    canvas.setWidth(417);
    canvas.setHeight(590);

    $('#add-text').click(function() {
        var objectId = id;

        var text = new fabric.Text(
            'Escriba el texto aquí',
            {
                id: objectId,
                hasRotatingPoint: false,
                originX: 'center',
                originY: 'center'
            });

        canvas.centerObject(text);

        text.customiseCornerIcons(customizeControlsOptions, function() {
            canvas.renderAll();
        });

        canvas.add(text);

        canvas.setActiveObject(text);

        $('#text').focus();
        $('#text').select();
        $('#canvas-tools').hide();

        addLayer('Texto' + objectId, objectId);
        id++;

        var tour1 = new Tour({
            name: 'tour2',
            steps: [
                {
                    element: "#text-tools",
                    title: "Edición de texto",
                    content: "Personalice el texto con los siguientes controles."
                },
                {
                    element: "#common-tools",
                    title: "Otras opciones de personalización",
                    content: "Aquí se encuentran otras opciones..."
                }
            ],
            template: "<div class='popover tour'> <div class='arrow'></div> <h3 class='popover-title'></h3> <div class='popover-content'></div> <div class='popover-navigation'> <button class='btn btn-default btn-sm' data-role='prev'>« Ant</button> <span data-role='separator'>|</span> <button class='btn btn-default btn-sm' data-role='next'>Sig »</button>  <button class='btn btn-default btn-sm' data-role='end' style='margin-left: 5px'>Cerrar</button> </div> </div>"
        });
        tour1.init();
        tour1.start();
    });

    $('#imageInput').on("change", function(e) {
        var file = e.target.files[0];
        var reader = new FileReader();

        reader.onload = function(f) {
            var data = f.target.result;
            var objectId = id;

            fabric.Image.fromURL(data, function(img) {
                var oImg = img.set({
                    id: objectId,
                    hasRotatingPoint: false,
                    originX: 'center',
                    originY: 'center'
                }).scale(0.25);

                canvas.centerObject(oImg);

                oImg.customiseCornerIcons(customizeControlsOptions, function() {
                    canvas.renderAll();
                });

                canvas.add(oImg).renderAll();

                canvas.setActiveObject(oImg);

                $('#canvas-tools').hide();

                addLayer('Imagen' + objectId, objectId)
                id++;

                var tour2 = new Tour({
                    name: 'tour35',
                    backdropPadding: 'left',
                    steps: [
                        {
                            element: "#image-tools",
                            placement: "left",
                            title: "Edición de imagen",
                            content: "Personalice la imagen con los siguientes controles."
                        },
                        {
                            element: "#common-tools",
                            placement: "left",
                            title: "Otros controles",
                            content: "Eliga otras personalizaciones aquí."
                        }
                    ],
                    template: "<div class='popover tour'> <div class='arrow'></div> <h3 class='popover-title'></h3> <div class='popover-content'></div> <div class='popover-navigation'> <button class='btn btn-default btn-sm' data-role='prev'>« Ant</button> <span data-role='separator'>|</span> <button class='btn btn-default btn-sm' data-role='next'>Sig »</button>  <button class='btn btn-default btn-sm' data-role='end' style='margin-left: 5px'>Cerrar</button> </div> </div>"
                });

                tour2.init();
                tour2.start();
            });
        };
        reader.readAsDataURL(file);

        this.value = "";
    });

    function addLayer(name, objectId) {
        $(".list-group-item").removeClass("active");
        $("#container-layers").prepend('<li  id="' + objectId + '" href="#" class="list-group-item active">' + name + '</li>');

        $("#" + objectId).click(function(e) {
            $(".list-group-item").removeClass("active");
            $(this).addClass("active");
            canvas.getObjects().forEach(function(o) {
                if (o.id == objectId) {
                    canvas.setActiveObject(o);
                }
            });
            canvas.renderAll();
        });

        $('#no-layer').hide();

        $('#deselect-all').show();
    }

    $('#changeImageInput').on("change", function(e) {
        var file = e.target.files[0];
        var reader = new FileReader();

        var selectedObject = canvas.getActiveObject();

        reader.onload = function(f) {
            var data = f.target.result;

            selectedObject.setSrc(data);

            setTimeout(function() {
                canvas.renderAll();
            }, 1000);
        };
        reader.readAsDataURL(file);
    });

    $('#canvas-color').minicolors({
        theme: 'bootstrap',
        change: function(hex) {
            canvas.backgroundColor = hex;
            canvas.renderAll();
        }
    });

    $('#text').on("change keyup paste", function(e) {
        var selectedObject = canvas.getActiveObject();
        if (selectedObject && (selectedObject.type === 'text' || selectedObject.type === 'curvedText')) {
            selectedObject.setText($('#text').val());
            canvas.renderAll();

            $('#btn-align-center').click();
        }
    });

    $('#text-color').minicolors({
        theme: 'bootstrap',
        change: function(hex) {
            var selectedObject = canvas.getActiveObject();
            if (selectedObject && (selectedObject.type === 'text' || selectedObject.type === 'curvedText')) {
                selectedObject.setColor(hex);
                canvas.renderAll();
            }
        }
    });

    $('#text-font').change(function(e) {
        var activeObject = canvas.getActiveObject();
        if (activeObject && (activeObject.type === 'text' || activeObject.type === 'curvedText')) {
            activeObject.set('fontFamily', $(this).val());
            canvas.renderAll();

            if (activeObject.type === 'curvedText') {
                setTimeout(function() {
                    $('#btn-align-center').click();
                }, 10);
            }
        }
    });

    $('#btn-remove-object').click(function(e) {
        var selectedObject = canvas.getActiveObject();
        canvas.remove(selectedObject);

        canvas.renderAll();
    });

    $('#btn-decrease-size').click(function() {
        var selectedObject = canvas.getActiveObject();

        var scaleX = selectedObject.getScaleX();
        var scaleY = selectedObject.getScaleY();

        selectedObject.setScaleX(scaleX - 0.1);
        selectedObject.setScaleY(scaleY - 0.1);

        canvas.renderAll();
    });

    $('#btn-increase-size').click(function() {
        var selectedObject = canvas.getActiveObject();

        var scaleX = selectedObject.getScaleX();
        var scaleY = selectedObject.getScaleY();

        selectedObject.setScaleX(scaleX + 0.1);
        selectedObject.setScaleY(scaleY + 0.1);

        canvas.renderAll();
    });

    $('#btn-align-left').click(function(e) {
        var selectedObject = canvas.getActiveObject();
        if (selectedObject && (selectedObject.type === 'text' || selectedObject.type === 'curvedText')) {
            selectedObject.setTextAlign('left');

            $(this).addClass("active");
            $('#btn-align-center').removeClass('active');
            $('#btn-align-right').removeClass('active');

            canvas.renderAll();
        }
    });

    $('#btn-align-center').click(function(e) {
        var selectedObject = canvas.getActiveObject();
        if (selectedObject && (selectedObject.type === 'text' || selectedObject.type === 'curvedText')) {
            selectedObject.setTextAlign('center');

            $(this).addClass("active");
            $('#btn-align-left').removeClass('active');
            $('#btn-align-right').removeClass('active');

            canvas.renderAll();
        }
    });

    $('#btn-align-right').click(function(e) {
        var selectedObject = canvas.getActiveObject();
        if (selectedObject && (selectedObject.type === 'text' || selectedObject.type === 'curvedText')) {
            selectedObject.setTextAlign('right');

            $(this).addClass("active");
            $('#btn-align-center').removeClass('active');
            $('#btn-align-left').removeClass('active');

            canvas.renderAll();
        }
    });

    $('#btn-bold').click(function(e) {
        var selectedObject = canvas.getActiveObject();
        if (selectedObject && (selectedObject.type === 'text' || selectedObject.type === 'curvedText')) {
            var isBold = (selectedObject.fontWeight === 'bold');
            if (isBold) {
                $(this).removeClass("active");
            } else {
                $(this).addClass("active");
            }
            selectedObject.set('fontWeight', (isBold ? '' : 'bold'));
            canvas.renderAll();
        }
    });

    $('#btn-italic').click(function(e) {
        var selectedObject = canvas.getActiveObject();
        if (selectedObject && (selectedObject.type === 'text' || selectedObject.type === 'curvedText')) {
            var isItalic = (selectedObject.fontStyle === 'italic');
            if (isItalic) {
                $(this).removeClass("active");
            } else {
                $(this).addClass("active");
            }
            selectedObject.set('fontStyle', (isItalic ? '' : 'italic'));
            canvas.renderAll();
        }
    });

    $('#btn-underline').click(function(e) {
        var selectedObject = canvas.getActiveObject();
        if (selectedObject && (selectedObject.type === 'text' || selectedObject.type === 'curvedText')) {
            var isUnderline = (selectedObject.textDecoration === 'underline');
            if (isUnderline) {
                $(this).removeClass("active");
            } else {
                $(this).addClass("active");
            }

            selectedObject.setTextDecoration(isUnderline ? '' : 'underline');
            canvas.renderAll();
        }
    });

    // $('#text-line-height').on('input change', function (e) {
    //     var selectedObject = canvas.getActiveObject();
    //     if (selectedObject && selectedObject.type === 'text') {
    //         selectedObject.setLineHeight($('#text-line-height').val());
    //         canvas.renderAll();
    //     }
    // });

    $('#scale').on('input change', function(e) {
        var selectedObject = canvas.getActiveObject();
        selectedObject.setScaleX($('#scale').val());
        selectedObject.setScaleY($('#scale').val());

        canvas.renderAll();
    });

    $('#remove-white').change(function(e) {
        var activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'image') {
            if (this.checked) {
                var filter = new fabric.Image.filters.RemoveWhite({
                    threshold: 40,
                    distance: 140
                });
                activeObject.filters[2] = filter;
                activeObject.applyFilters(canvas.renderAll.bind(canvas));
            } else {
                activeObject.filters[2] = null;
                activeObject.applyFilters(canvas.renderAll.bind(canvas));
            }

            canvas.renderAll();
        }
    });

    $('#brightness-value').on('input change', function(e) {
        var activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'image') {
            if (!activeObject.filters[3]) {
                var filter = new fabric.Image.filters.Brightness({
                    brightness: parseInt($('#brightness-value').val(), 10)
                });
                activeObject.filters[3] = filter;
            }

            activeObject.filters[3]['brightness'] = parseInt($('#brightness-value').val(), 10);
            activeObject.applyFilters(canvas.renderAll.bind(canvas));

            canvas.renderAll();
        }
    });

    $('#sepia').click(function(e) {
        var activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'image') {
            if (!activeObject.filters[4]) {
                var filter = new fabric.Image.filters.Sepia();
                activeObject.filters[4] = filter;
            } else {
                activeObject.filters[4] = undefined;
            }

            activeObject.applyFilters(canvas.renderAll.bind(canvas));

            canvas.renderAll();
        }
    });

    $('#sepia2').click(function(e) {
        var activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'image') {
            if (!activeObject.filters[9]) {
                var filter = new fabric.Image.filters.Sepia2();
                activeObject.filters[9] = filter;
            } else {
                activeObject.filters[9] = undefined;
            }

            activeObject.applyFilters(canvas.renderAll.bind(canvas));

            canvas.renderAll();
        }
    });

    $('#grayscale').click(function(e) {
        var activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'image') {
            if (!activeObject.filters[5]) {
                var filter = new fabric.Image.filters.Grayscale();
                activeObject.filters[5] = filter;
            } else {
                activeObject.filters[5] = undefined;
            }

            activeObject.applyFilters(canvas.renderAll.bind(canvas));

            canvas.renderAll();
        }
    });

    $('#contrast-value').on('input change', function(e) {
        var activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'image') {
            if (!activeObject.filters[6]) {
                var filter = new fabric.Image.filters.Contrast({
                    contrast: parseInt($('#contrast-value').val(), 10)
                });
                activeObject.filters[6] = filter;
            }

            activeObject.filters[6]['contrast'] = parseInt($('#contrast-value').val(), 10);
            activeObject.applyFilters(canvas.renderAll.bind(canvas));

            canvas.renderAll();
        }
    });

    $('#saturation-value').on('input change', function(e) {
        var activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'image') {
            if (!activeObject.filters[7]) {
                var filter = new fabric.Image.filters.Saturate({
                    saturate: parseInt($('#saturation-value').val(), 10)
                });
                activeObject.filters[7] = filter;
            }

            activeObject.filters[7]['saturate'] = parseInt($('#saturation-value').val(), 10);
            activeObject.applyFilters(canvas.renderAll.bind(canvas));

            canvas.renderAll();
        }
    });

    $('#pixelate-value').on('input change', function(e) {
        var activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'image') {
            if (!activeObject.filters[8]) {
                var filter = new fabric.Image.filters.Pixelate({
                    blocksize: parseInt($('#pixelate-value').val(), 10)
                });
                activeObject.filters[8] = filter;
            }

            activeObject.filters[8]['blocksize'] = parseInt($('#pixelate-value').val(), 10);
            activeObject.applyFilters(canvas.renderAll.bind(canvas));

            canvas.renderAll();
        }
    });

    $('#btn-to-back').click(function(e) {
        var selectedObject = canvas.getActiveObject();
        selectedObject.sendToBack();
        canvas.renderAll();
    });

    $('#btn-to-front').click(function(e) {
        var selectedObject = canvas.getActiveObject();
        selectedObject.bringToFront();
        canvas.renderAll();
    });

    $('#btn-center-vertically').click(function(e) {
        var selectedObject = canvas.getActiveObject();
        selectedObject.centerV();
        canvas.renderAll();
    });

    $('#btn-center-horizontally').click(function(e) {
        var selectedObject = canvas.getActiveObject();
        selectedObject.centerH();
        canvas.renderAll();
    });

    $('#btn-flip-vertically').click(function(e) {
        var selectedObject = canvas.getActiveObject();
        selectedObject.set('flipY', !selectedObject.flipY);
        canvas.renderAll();
    });

    $('#btn-flip-horizontally').click(function(e) {
        var selectedObject = canvas.getActiveObject();
        selectedObject.set('flipX', !selectedObject.flipX);
        canvas.renderAll();
    });

    $('#deselect-all').click(function() {
        canvas.deactivateAll().renderAll();

        onSelectedCleared();
    });

    $('#btn-rotate-left').click(function() {
        var selectedObject = canvas.getActiveObject();
        var currentAngle = selectedObject.getAngle();

        selectedObject.setAngle(currentAngle - 90);
        canvas.renderAll();
    });

    $('#btn-rotate-right').click(function() {
        var selectedObject = canvas.getActiveObject();
        var currentAngle = selectedObject.getAngle();

        selectedObject.setAngle(currentAngle + 90);
        canvas.renderAll();
    });

    $('#finalize-edit-text-button').click(function() {
        canvas.deactivateAll().renderAll();

        onSelectedCleared();
    });

    $('#finalize-edit-image-button').click(function() {
        canvas.deactivateAll().renderAll();

        onSelectedCleared();
    });

    $('#text-curved').on('change', function(e) {
        if (this.checked) {
            $('#input-radius').show();
            $('#input-spacing').show();
        } else {
            $('#input-radius').hide();
            $('#input-spacing').hide();
        }

        canvas.renderAll();
        var props = {};
        var obj = canvas.getActiveObject();
        if (obj) {
            var objectId = obj.id;
            if (/curvedText/.test(obj.type)) {
                var default_text = obj.getText();
                props = obj.toObject();
                delete props['type'];
                props['id'] = objectId;
                props['hasRotatingPoint'] = false;
                var textSample = new fabric.Text(default_text, props);
            } else if (/text/.test(obj.type)) {
                var default_text = obj.getText();
                props = obj.toObject();
                delete props['type'];
                props['textAlign'] = 'center';
                props['radius'] = 150;
                props['id'] = objectId;
                props['hasRotatingPoint'] = false;
                var textSample = new fabric.CurvedText(default_text, props);
            }
            canvas.remove(obj);

            addLayer('Texto' + textSample.id, textSample.id);

            textSample.customiseCornerIcons({
                settings: {
                    borderColor: 'black',
                    cornerSize: 25,
                    cornerShape: 'rect',
                    cornerBackgroundColor: 'black',
                    cornerPadding: 10
                },
                bl: {
                    icon: '../editor-assets/icons/remove.svg'
                },
                tr: {
                    icon: '../editor-assets/icons/resize.svg'
                },
                tl: {
                    icon: '../editor-assets/icons/rotate.svg'
                }
            }, function() {
                canvas.renderAll();
            });

            canvas.add(textSample);
            canvas.renderAll();
            setTimeout(function() {
                canvas.setActiveObject(textSample);
            }, 10);
        }
    });

    $('#radius, #spacing').change(function(e) {
        var obj = canvas.getActiveObject();
        if (obj) {
            obj.set($(this).attr('id'), $(this).val());
        }
        canvas.renderAll();
    });

    function onObjectSelected(e) {
        var selectedObject = e.target;
        $("#text").val("");
        $('#canvas-tools').hide();
        if (selectedObject && (selectedObject.type === 'text' || selectedObject.type === 'curvedText')) {
            $("#text-tools").show();
            $("#image-tools").hide();
            $("#text").val(selectedObject.getText());
            $('#text-color').minicolors('value', selectedObject.fill);
            //$('#text-line-height').val(selectedObject.getLineHeight());
            if (selectedObject.type === 'curvedText') {
                $('#input-radius').show();
                $('#input-spacing').show();
                $('#text-curved').prop('checked', true);
                $('#radius').val(selectedObject.get('radius'));
                $('#spacing').val(selectedObject.get('spacing'));
            } else {
                $('#input-radius').hide();
                $('#input-spacing').hide();
                $("#text-curved").prop('checked', false);
            }

            var isBold = (selectedObject.fontWeight === 'bold');
            if (isBold) {
                $('#btn-bold').addClass("active");
            } else {
                $('#btn-bold').removeClass("active");
            }

            var isUnderline = (selectedObject.textDecoration === 'underline');
            if (isUnderline) {
                $('#btn-underline').addClass("active");
            } else {
                $('#btn-underline').removeClass("active");
            }

            var isItalic = (selectedObject.fontStyle === "italic");
            if (isItalic) {
                $('#btn-italic').addClass("active");
            } else {
                $('#btn-italic').removeClass("active");
            }

            $('#btn-align-left').removeClass("active");
            $('#btn-align-center').removeClass('active');
            $('#btn-align-right').removeClass('active');

            var textAlign = selectedObject.getTextAlign();
            switch (textAlign) {
                case "left":
                    $('#btn-align-left').addClass("active");
                    break;
                case "center":
                    $('#btn-align-center').addClass("active");
                    break;
                case "right":
                    $('#btn-align-right').addClass("active");
                    break;
            }

            $('#finalize-edit-text-button').show();
            $('#finalize-edit-image-button').hide();
        }
        else if (selectedObject && selectedObject.type === 'image') {
            $("#text-tools").hide();
            $("#image-tools").show();

            console.log(selectedObject.filters[3] != null)

            if (selectedObject.filters[3] != null) {
                $('#brightness').prop('checked', true);
            } else {
                $('#brightness').prop('checked', false);
            }

            $('#finalize-edit-text-button').hide();
            $('#finalize-edit-image-button').show();
        }

        $('#scale').val(selectedObject.getScaleX());

        $('#common-tools').show();

        $('.list-group-item').removeClass('active');
        $('#' + selectedObject.id).addClass('active');

        $('[data-toggle="popover"]').css({
                'position': 'absolute',
                'top': selectedObject.top + (selectedObject.height),
                'left': selectedObject.left + selectedObject.width
            }
        ).popover({
            trigger: 'click',
            placement: 'right',
        }).popover('show');
    }

    $('#save-image').click(function() {
        $("#canvas-paper-a4").get(0).toBlob(function(blob) {
            saveAs(blob, "myIMG.png");
        });
    });

    $('#save-image-circle').click(function() {
        $("#canvas-paper-a4").get(0).toBlob(function(blob) {
            //saveAs(blob, "myIMG.png");

            var image = new Image();
            image.id = "pic"
            image.src = canvas.toDataURL();

            $('#circle-image').attr("src", image.src);

            $('#circle-image').croppie({
                enableExif: true,
                viewport: {
                    width: 200,
                    height: 200,
                    type: 'circle'
                }
            });

            setTimeout(function() {
                $('#circle-image').croppie('result', {type: 'blob'}).then(function(resp) {
                    saveAs(resp, 'img.png')
                });
            }, 1000)

        });
    });

    $('#save-svg').click(function() {
        var svgFile = new Blob([canvas.toSVG()], {type: "image/svg+xml;charset=utf-8"});

        saveAs(svgFile, "canvas.svg");
    });

    $('#save-json').click(function() {
        alert(JSON.stringify(canvas));
    });

    $('#save-design').click(function(event) {
        event.preventDefault();

        var json = JSON.stringify(canvas);

        $('#save-design-form #json').val(json);

        $('#save-design-form').submit();
    });

    function onObjectRemoved(e) {
        var objectRemoved = e.target;

        $('#' + objectRemoved.id).remove();

        setTimeout(function() {
            $("#text-tools").hide();
            $("#text").val("");
            $("#image-tools").hide();
            $('#common-tools').hide();
        }, 10);

        $('.list-group-item').removeClass('active');

        if (canvas.getObjects().length == 0) {
            $('#no-layer').show();
            $('#deselect-all').hide();
        }
    }

    function onSelectedCleared(e) {
        $("#text-tools").hide();
        $("#text").val("");
        $('#common-tools').hide();
        $("#image-tools").hide();
        $("#canvas-tools").show();

        $('.list-group-item').removeClass('active');
    }

    /**
     * Functions available to designers
     */

    $('#block').change(function() {
        var selectedObject = canvas.getActiveObject();
        selectedObject.set('selectable', !selectedObject.selectable);
        selectedObject.set('evented', !selectedObject.evented);
        canvas.renderAll();
    });

    $('#clipping').change(function() {
        var selectedImage = canvas.getActiveObject();
        if (selectedImage.type === 'image') {
            selectedImage.set('clipName', selectedImage.id);
        }

        var clipRect = new fabric.Rect({
            originX: selectedImage.originX,
            originY: selectedImage.originY,
            left: selectedImage.left,
            top: selectedImage.top,
            width: selectedImage.width,
            height: selectedImage.height,
            fill: '#DDD', /* use transparent for no fill */
            strokeWidth: 0,
            selectable: false
        });

        clipRect.set({
            clipFor: selectedImage.id
        });

        selectedImage.set('clipTo', function(ctx) {
            return _.bind(clipByName, selectedImage)(ctx)
        });

        canvas.add(clipRect);

        canvas.bringToFront(selectedImage);

        // var pugImg = new Image();
        // pugImg.onload = function (img) {
        //     var pug = new fabric.Image(pugImg, {
        //         width: 100,
        //         height: 100,
        //         left: 230,
        //         top: 50,
        //         clipName: 'pug'
        //     });
        //
        //     pug.customiseCornerIcons({
        //         settings: {
        //             borderColor: 'black',
        //             cornerSize: 25,
        //             cornerShape: 'rect',
        //             cornerBackgroundColor: 'black',
        //             cornerPadding: 10
        //         },
        //         bl: {
        //             icon: 'icons/remove.svg'
        //         },
        //         tr: {
        //             icon: 'icons/resize.svg'
        //         },
        //         tl: {
        //             icon: 'icons/rotate.svg'
        //         }
        //     }, function () {
        //         canvas.renderAll();
        //     });
        //
        //     canvas.add(pug);
        //
        //     var clipRect2 = new fabric.Rect({
        //         originX: 'left',
        //         originY: 'top',
        //         left: 230,
        //         top: 50,
        //         width: 100,
        //         height: 100,
        //         fill: '#DDD', /* use transparent for no fill */
        //         strokeWidth: 0,
        //         selectable: false
        //     });
        //
        //     clipRect2.set({
        //         clipFor: 'pug'
        //     });
        //
        //     pug.set('clipTo', function(ctx) {
        //         return _.bind(clipByName, pug)(ctx)
        //     });
        //
        //     canvas.add(clipRect2);
        //
        //     canvas.bringToFront(pug)
        // };
        //
        // pugImg.src = img02URL;
    });

    function findByClipName(name) {
        return _(canvas.getObjects()).where({
            clipFor: name
        }).first()
    }

// Since the `angle` property of the Image object is stored
// in degrees, we'll use this to convert it to radians.
    function degToRad(degrees) {
        return degrees * (Math.PI / 180);
    }

    var clipByName = function(ctx) {
        var clipRect = findByClipName(this.clipName);
        var scaleXTo1 = (1 / this.scaleX);
        var scaleYTo1 = (1 / this.scaleY);
        ctx.save();
        ctx.translate(0, 0);
        ctx.rotate(degToRad(this.angle * -1));
        ctx.scale(scaleXTo1, scaleYTo1);
        ctx.beginPath();
        ctx.rect(
            (clipRect.left - this.left) - 155,
            (clipRect.top - this.top) - 70,
            clipRect.width,
            clipRect.height
        );
        console.log(clipRect.left - this.left)
        ctx.closePath();
        ctx.restore();


        // // var isPolygon = clipObj instanceof fabric.Polygon;
        // // // polygon cliping area
        // // if(isPolygon)
        // // {
        // //     // prepare points of polygon
        // //     var points = [];
        // //     for(i in clipObj.points)
        // //         points.push({
        // //             x: (clipObj.left + clipObj.width / 2) + clipObj.points[i].x - this.oCoords.tl.x,
        // //             y: (clipObj.top + clipObj.height / 2) + clipObj.points[i].y - this.oCoords.tl.y
        // //         });
        // //
        // //     ctx.moveTo(points[0].x, points[0].y);
        // //     for(i=1; i<points.length; ++i)
        // //     {
        // //         ctx.lineTo(points[i].x, points[i].y);
        // //     }
        // //     ctx.lineTo(points[0].x, points[0].y);
        // // }
        // // // rectangle cliping area
        // // else
        // // {
        // //     ctx.rect(
        // //         clipObj.left - this.oCoords.tl.x,
        // //         clipObj.top - this.oCoords.tl.y,
        // //         clipObj.width,
        // //         clipObj.height
        // //     );
        // // }
        //
        //      ctx.rect(
        //         clipObj.left,
        //         clipObj.top,
        //         clipObj.width,
        //         clipObj.height
        //     );
        //
        // ctx.closePath();
        // ctx.restore();
    }


});
