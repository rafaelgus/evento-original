<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreOccasionRequest;
use App\Http\Requests\Backend\UpdateOccasionRequest;
use EventoOriginal\Core\Services\OccasionService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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
        $occasions = $this->occasionService->findAll(app()->getLocale());

        return view('backend/admin.occasions.index')->with('occasions', $occasions);
    }

    public function create()
    {
        $occasions = $this->occasionService->findAll(app()->getLocale());

        return view('backend/admin.occasions.create')->with('occasions', $occasions);
    }

    public function store(StoreOccasionRequest $request)
    {
        try {
            $this->occasionService->create($request->all());

            Session::flash('message', "Ocasion creada con exito");
        } catch (Exception $exception) {
            Session::flash('message-error', "Ha ocurrido un error");
            Log::error('Error when try to store occasion: ' . $exception->getMessage());
        }

        return redirect()->back();
    }

    public function edit(int $id)
    {
        $occasion = $this->occasionService->findOneById($id, app()->getLocale());

        if (!$occasion) {
            abort(404);
        }

        $occasions = $this->occasionService->findAll(app()->getLocale());

        return view('backend/admin.occasions.edit')->with([
            'occasion' => $occasion,
            'occasions' => $occasions,
        ]);
    }

    public function update(UpdateOccasionRequest $request, int $id)
    {
        try {
            $data = $request->all();

            $occasion = $this->occasionService->findOneById($id, app()->getLocale());

            $this->occasionService->update($occasion, $data);

            Session::flash('message', "Ocasion editada con éxito");
        } catch (Exception $exception) {
            Session::flash('message-error', trans('backend/messages.error.create'));
            Log::error('Error when try to store occasion: ' . $exception->getMessage());
        }

        return redirect()->back();
    }
}
