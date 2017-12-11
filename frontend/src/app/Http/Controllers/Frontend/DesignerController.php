<?php
namespace App\Http\Controllers\Frontend;

class DesignerController
{
    public function showEditor()
    {
        return view('frontend/designer.editor');
    }
}
