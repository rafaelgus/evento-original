<!doctype html>
<html lang="es-AR" style="margin:0 0 0 0; padding: 0 0 0 0;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>

@for ($i = 0; $i < $quantity; $i++)
    <img src="{{ $design->getImage() }}" width="{{ $width }}" height="{{ $height }}">

    @if ($i < $quantity - 1)
    <div class="page-break"></div>
    @endif
@endfor


</body>

</html>