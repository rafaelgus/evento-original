<?php
namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\UpdateCategoryRequest;
use App\Http\Requests\StoreTagRequest;
use EventoOriginal\Core\Services\TagService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Facades\Datatables;

class TagController
{
    protected $tagService;

    const TAG_CREATE_ROUTE = '/management/tags/create';

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function index()
    {
        return view('backend.admin.tags.index');
    }

    public function create()
    {
        return view('backend.admin.tags.create');
    }

    public function edit(int $id)
    {
        $tag = $this->tagService->findOneById($id, App::getLocale());

        if (!$tag) {
            throw new \Exception('Tag does not exist');
        }

        return view('backend.admin.tags.edit', ['tag' => $tag]);
    }

    public function store(StoreTagRequest $request)
    {
        $this->tagService->create($request->input('name'));

        Session::flash('message', trans('backend/messages.confirmation.create.tags'));

        return redirect()->to(self::TAG_CREATE_ROUTE);
    }

    public function update(int $id, UpdateCategoryRequest $request)
    {
        $tag = $this->tagService->findOneById($id, App::getLocale());

        $this->tagService->update($tag, $request->input('name'));

        Session::flash('message', trans('backend/messages.confirmation.edit.tags'));

        return redirect()->to('/management/tags/'. $id . '/edit');
    }

    public function getDataTables()
    {
        $tags = $this->tagService->findAll('es');
        $tagsCollection = new Collection();

        foreach ($tags as $tag) {
            $tagsCollection->push([
                'id' => $tag->getId(),
                'name' => $tag->getName()
            ]);
        }

        return Datatables::of($tagsCollection)->make(true);
    }
}