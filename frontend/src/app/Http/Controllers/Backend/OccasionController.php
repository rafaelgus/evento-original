<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use EventoOriginal\Core\Services\OccasionService;

class OccasionController extends Controller
{
    /**
     * @var OccasionService
     */
    private $occasionService;

    /**
     * OccasionController constructor.
     * @param OccasionService $occasionService
     */
    public function __construct(
        OccasionService $occasionService
    ) {
        $this->occasionService = $occasionService;
    }

    public function index()
    {

    }

    public function create()
    {

    }

    public function store()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }
}
