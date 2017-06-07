<?php
// Codigo para colocar circulos en un pdf
require('fpdf181/fpdf.php');

$pdf = new FPDF($orientation='P',$unit='cm',$format='A4');

const ALTO_A4 = 29.7;
const ANCHO_A4 = 21;

$cantidad_circulos = 12;

$alto = 5;
$ancho = 5;

$cantidad_columnas = floor(ANCHO_A4 / ($ancho + 0.5));
$cantidad_filas_por_pagina = floor(ALTO_A4 / ($alto + 0.5));

$cantidad_filas_requeridas = $cantidad_circulos / $cantidad_columnas;

$cantidad_paginas = ceil($cantidad_filas_requeridas / $cantidad_filas_por_pagina);

$cantidad_circulos_dibujados = 0;

for($pagina = 1; $pagina <= $cantidad_paginas; $pagina++ )
{
    $pdf->AddPage();

    $margen_sup = 1;

    for($i = 1;$i <= $cantidad_filas_por_pagina; $i++)
    {
        $margen_izq = 1;

        for ($y = 1; $y <= $cantidad_columnas; $y++)
        {
            if ($cantidad_circulos_dibujados < $cantidad_circulos) {
                $pdf->Image('img/myIMG.png', $margen_izq, $margen_sup, $ancho, $alto, 'PNG');
                $cantidad_circulos_dibujados++;
            }
            $margen_izq += ($ancho + 0.5);
        }

        $margen_sup += ($alto + 0.5);
    }
}
$pdf->Output();
?>