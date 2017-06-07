$('#add-image').click(function () {
    $('#imageInput').click();
});

$('#change-image').click(function () {
    $('#changeImageInput').click();
});

var canvas;
var id = 1;

$(document).ready(function () {
    canvas = new fabric.Canvas('canvas-paper-a4', {
        hoverCursor: 'pointer',
        selection: true,
        selectionBorderColor: 'blue',
        backgroundColor: 'white',
        borderColor: 'black'
    });

    fabric.Object.prototype.setControlsVisibility({
        ml: false,
        mr: false,
        mb: false,
        mtr: false,
        mt: false,
        br: false
    });

    fabric.Object.prototype.customiseCornerIcons({
        settings: {
            borderColor: '#0094dd',
            cornerSize: 25,
            cornerShape: 'rect'
        },
        tr: {
            icon: 'icons/remove.svg'
        },
        br: {
            icon: 'icons/resize.svg'
        },
        mt: {
            icon: 'icons/rotate.svg'
        }
    }, function () {
        canvas.renderAll();
    });

    fabric.Canvas.prototype.customiseControls({
        bl: {
            action: function() {
                var selectedObject = canvas.getActiveObject();

                selectedObject.visible = false;

                canvas.remove(selectedObject);
                canvas.renderAll();
            },
            cursor: 'pointer'
        },
        tr: {
            action: 'scale'
        },
        tl: {
            action: 'rotate',
            cursor: 'pointer'
        }
    });

    canvas.on({
        'object:moving': function (e) {
            e.target.opacity = 0.5;
        },
        'object:modified': function (e) {
            e.target.opacity = 1;
        },
        'object:selected': onObjectSelected,
        'object:removed': onObjectRemoved,
        'selection:cleared': onSelectedCleared
    });

    canvas.setWidth(500);
    canvas.setHeight(500);

    $('#add-text').click(function () {
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

        text.customiseCornerIcons({
            settings: {
                borderColor: 'black',
                cornerSize: 25,
                cornerShape: 'rect',
                cornerBackgroundColor: 'black',
                cornerPadding: 10
            },
            bl: {
                icon: 'icons/remove.svg'
            },
            tr: {
                icon: 'icons/resize.svg'
            },
            tl: {
                icon: 'icons/rotate.svg'
            }
        }, function () {
            canvas.renderAll();
        });

        canvas.add(text);

        canvas.setActiveObject(text);

        $('#text').focus();

        addLayer('Texto' + objectId, objectId)
        id++;
    });

    $('#imageInput').on("change", function (e) {
        var file = e.target.files[0];
        var reader = new FileReader();

        reader.onload = function (f) {
            var data = f.target.result;
            var objectId = id;

            fabric.Image.fromURL(data, function (img) {
                var oImg = img.set({
                    id: objectId,
                    hasRotatingPoint: false,
                    originX: 'center',
                    originY: 'center'
                }).scale(0.9);

                canvas.centerObject(oImg);

                oImg.customiseCornerIcons({
                    settings: {
                        borderColor: 'black',
                        cornerSize: 25,
                        cornerShape: 'rect',
                        cornerBackgroundColor: 'black',
                        cornerPadding: 10
                    },
                    bl: {
                        icon: 'icons/remove.svg'
                    },
                    tr: {
                        icon: 'icons/resize.svg'
                    },
                    tl: {
                        icon: 'icons/rotate.svg'
                    }
                }, function () {
                    canvas.renderAll();
                });

                canvas.add(oImg).renderAll();

                canvas.setActiveObject(oImg);

                addLayer('Imagen' + objectId, objectId)
                id++;
            });
        };
        reader.readAsDataURL(file);

        this.value = "";
    });

    function addLayer(name, objectId) {
        $(".list-group-item").removeClass("active");
        $("#container-layers").prepend('<li  id="' + objectId + '" href="#" class="list-group-item active">' + name + '</li>');

        $("#" + objectId).click(function (e) {
            $(".list-group-item").removeClass("active");
            $(this).addClass("active");
            canvas.getObjects().forEach(function (o) {
                if (o.id == objectId) {
                    canvas.setActiveObject(o);
                }
            });
            canvas.renderAll();
        });

        $('#no-layer').hide();

        $('#deselect-all').show();
    }

    $('#changeImageInput').on("change", function (e) {
        var file = e.target.files[0];
        var reader = new FileReader();

        var selectedObject = canvas.getActiveObject();

        reader.onload = function (f) {
            var data = f.target.result;

            selectedObject.setSrc(data);

            setTimeout(function () {
                canvas.renderAll();
            }, 1000);
        };
        reader.readAsDataURL(file);
    });

    $('#canvas-color').minicolors({
        theme: 'bootstrap',
        change: function (hex) {
            canvas.backgroundColor = hex;
            canvas.renderAll();
        }
    });

    $('#text').on("change keyup paste", function (e) {
        var selectedObject = canvas.getActiveObject();
        if (selectedObject && (selectedObject.type === 'text' || selectedObject.type === 'curvedText')) {
            selectedObject.setText($('#text').val());
            canvas.renderAll();

            $('#btn-align-center').click();
        }
    });

    $('#text-color').minicolors({
        theme: 'bootstrap',
        change: function (hex) {
            var selectedObject = canvas.getActiveObject();
            if (selectedObject && (selectedObject.type === 'text' || selectedObject.type === 'curvedText')) {
                selectedObject.setColor(hex);
                canvas.renderAll();
            }
        }
    });

    $('#text-font').change(function (e) {
        var activeObject = canvas.getActiveObject();
        if (activeObject && (activeObject.type === 'text' || activeObject.type === 'curvedText')) {
            activeObject.set('fontFamily', $(this).val());
            canvas.renderAll();

            if (activeObject.type === 'curvedText') {
                setTimeout(function () {
                    $('#btn-align-center').click();
                }, 10);
            }
        }
    });

    $('#btn-align-left').click(function (e) {
        var selectedObject = canvas.getActiveObject();
        if (selectedObject && (selectedObject.type === 'text' || selectedObject.type === 'curvedText')) {
            selectedObject.setTextAlign('left');
            canvas.renderAll();
        }
    });

    $('#btn-align-center').click(function (e) {
        var selectedObject = canvas.getActiveObject();
        if (selectedObject && (selectedObject.type === 'text' || selectedObject.type === 'curvedText')) {
            selectedObject.setTextAlign('center');
            canvas.renderAll();
        }
    });

    $('#btn-align-right').click(function (e) {
        var selectedObject = canvas.getActiveObject();
        if (selectedObject && (selectedObject.type === 'text' || selectedObject.type === 'curvedText')) {
            selectedObject.setTextAlign('right');
            canvas.renderAll();
        }
    });

    $('#btn-bold').click(function (e) {
        var selectedObject = canvas.getActiveObject();
        if (selectedObject && (selectedObject.type === 'text' || selectedObject.type === 'curvedText')) {
            selectedObject.set('fontWeight', (selectedObject.fontWeight == 'bold' ? '' : 'bold'));
            canvas.renderAll();
        }
    });

    $('#btn-italic').click(function (e) {
        var selectedObject = canvas.getActiveObject();
        if (selectedObject && (selectedObject.type === 'text' || selectedObject.type === 'curvedText')) {
            selectedObject.set('fontStyle', (selectedObject.fontStyle == 'italic' ? '' : 'italic'));
            canvas.renderAll();
        }
    });

    $('#btn-underline').click(function (e) {
        var selectedObject = canvas.getActiveObject();
        if (selectedObject && (selectedObject.type === 'text' || selectedObject.type === 'curvedText')) {
            selectedObject.setTextDecoration((selectedObject.textDecoration == 'underline' ? '' : 'underline'));
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

    $('#scale').on('input change', function (e) {
        var selectedObject = canvas.getActiveObject();
        selectedObject.setScaleX($('#scale').val());
        selectedObject.setScaleY($('#scale').val());

        canvas.renderAll();
    });

    $('#remove-white').change(function (e) {
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

    $('#btn-to-back').click(function (e) {
        var selectedObject = canvas.getActiveObject();
        selectedObject.sendToBack();
        canvas.renderAll();
    });

    $('#btn-to-front').click(function (e) {
        var selectedObject = canvas.getActiveObject();
        selectedObject.bringToFront();
        canvas.renderAll();
    });

    $('#btn-center-vertically').click(function (e) {
        var selectedObject = canvas.getActiveObject();
        selectedObject.centerV();
        canvas.renderAll();
    });

    $('#btn-center-horizontally').click(function (e) {
        var selectedObject = canvas.getActiveObject();
        selectedObject.centerH();
        canvas.renderAll();
    });

    $('#btn-flip-vertically').click(function (e) {
        var selectedObject = canvas.getActiveObject();
        selectedObject.set('flipY', !selectedObject.flipY);
        canvas.renderAll();
    });

    $('#btn-flip-horizontally').click(function (e) {
        var selectedObject = canvas.getActiveObject();
        selectedObject.set('flipX', !selectedObject.flipX);
        canvas.renderAll();
    });

    $('#deselect-all').click(function () {
        canvas.deactivateAll().renderAll();

        onSelectedCleared();
    });

    $('#text-curved').change(function (e) {
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
                var textSample = new fabric.Text(default_text, props);
            } else if (/text/.test(obj.type)) {
                var default_text = obj.getText();
                props = obj.toObject();
                delete props['type'];
                props['textAlign'] = 'center';
                props['radius'] = 150;
                props['id'] = objectId;
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
                    icon: 'icons/remove.svg'
                },
                tr: {
                    icon: 'icons/resize.svg'
                },
                tl: {
                    icon: 'icons/rotate.svg'
                }
            }, function () {
                canvas.renderAll();
            });

            canvas.add(textSample);
            canvas.renderAll();
            setTimeout(function () {
                canvas.setActiveObject(textSample);
            }, 10);
        }
    });

    $('#radius, #spacing').change(function (e) {
        var obj = canvas.getActiveObject();
        if (obj) {
            obj.set($(this).attr('id'), $(this).val());
        }
        canvas.renderAll();
    });

    function onObjectSelected(e) {
        var selectedObject = e.target;
        $("#text").val("");
        if (selectedObject && (selectedObject.type === 'text' || selectedObject.type === 'curvedText')) {
            $("#text-tools").show();
            $("#image-tools").hide();
            $("#text").val(selectedObject.getText());
            $('#text-color').minicolors('value', selectedObject.fill);
            //$('#text-line-height').val(selectedObject.getLineHeight());
            if(selectedObject.type === 'curvedText') {
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
        }
        else if (selectedObject && selectedObject.type === 'image') {
            $("#text-tools").hide();
            $("#image-tools").show();
        }

        $('#scale').val(selectedObject.getScaleX());

        $('#common-tools').show();

        $('.list-group-item').removeClass('active');
        $('#' + selectedObject.id).addClass('active');
    }

    $('#save-image').click(function () {
        $("#canvas-paper-a4").get(0).toBlob(function (blob) {
            //saveAs(blob, "myIMG.png");

            var image = new Image();
            image.id = "pic"
            image.src = canvas.toDataURL();

            $('#circle-image').attr("src", image.src);

            $('#circle-image').croppie({
                enableExif: true,
                viewport: {
                    type: 'circle'
                }
            });

            setTimeout(function () {
                $('#circle-image').croppie('result', { type: 'blob'}).then(function(resp){
                    saveAs(resp, 'img.png')
                });

                $('#circle-image').croppie('destroy');
            }, 1000)
        });
    });

    $('#save-svg').click(function () {
        var svgFile = new Blob([canvas.toSVG()], {type: "image/svg+xml;charset=utf-8"});

        saveAs(svgFile, "canvas.svg");
    });

    $('#save-json').click(function () {
        alert(JSON.stringify(canvas));
    });

    function onObjectRemoved(e) {
        var objectRemoved = e.target;

        $('#' + objectRemoved.id).remove();

        setTimeout(function () {
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

        $('.list-group-item').removeClass('active');
    }

    /**
     * Functions available to designers
     */

    $('#block').change(function () {
        var selectedObject = canvas.getActiveObject();
        selectedObject.set('selectable', !selectedObject.selectable);
        canvas.renderAll();
    });

    $('#clipping').change(function () {
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

        selectedImage.set('clipTo', function (ctx) {
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

    var clipByName = function (ctx) {
        var clipRect = findByClipName(this.clipName);
        var scaleXTo1 = (1 / this.scaleX);
        var scaleYTo1 = (1 / this.scaleY);
        ctx.save();
        ctx.translate(0,0);
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
