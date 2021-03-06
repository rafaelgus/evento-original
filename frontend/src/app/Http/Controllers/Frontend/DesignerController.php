<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Backend\StoreDesignRequest;
use App\Http\Requests\SendDesignToReviewRequest;
use EventoOriginal\Core\Entities\Design;
use EventoOriginal\Core\Enums\DesignSource;
use EventoOriginal\Core\Enums\DesignStatus;
use EventoOriginal\Core\Enums\DesignType;
use EventoOriginal\Core\Services\ArticleService;
use EventoOriginal\Core\Services\CategoryService;
use EventoOriginal\Core\Services\CircularDesignVariantService;
use EventoOriginal\Core\Services\DesignerService;
use EventoOriginal\Core\Services\DesignService;
use EventoOriginal\Core\Services\OccasionService;
use Illuminate\Http\Request;

class DesignerController
{
    private $designerService;
    private $designService;
    private $circularDesignVariantService;
    /**
     * @var CategoryService
     */
    private $categoryService;
    /**
     * @var OccasionService
     */
    private $occasionService;
    /**
     * @var ArticleService
     */
    private $articleService;

    /**
     * DesignerController constructor.
     * @param DesignerService $designerService
     * @param DesignService $designService
     * @param CircularDesignVariantService $circularDesignVariantService
     * @param CategoryService $categoryService
     * @param OccasionService $occasionService
     * @param ArticleService $articleService
     */
    public function __construct(
        DesignerService $designerService,
        DesignService $designService,
        CircularDesignVariantService $circularDesignVariantService,
        CategoryService $categoryService,
        OccasionService $occasionService,
        ArticleService $articleService
    ) {
        $this->designerService = $designerService;
        $this->designService = $designService;
        $this->circularDesignVariantService = $circularDesignVariantService;
        $this->categoryService = $categoryService;
        $this->occasionService = $occasionService;
        $this->articleService = $articleService;
    }

    public function showEditor()
    {
        return view('frontend/designer.editor_edible_paper_a4');
    }

    /**
     * @param StoreDesignRequest $request
     * @return DesignerController
     * @throws \Exception
     */
    public function storeDesign(StoreDesignRequest $request)
    {
        $designer = current_user()->getDesigner();

        if ($designer) {
            $data = $request->all();
            $data['designer'] = $designer;

            $this->designService->saveDesignerDesign($data);
        }

        return $this->showDesigns();
    }

    public function showRejected(int $id)
    {
        $design = $this->designService->findOneById($id);

        if ($design->getStatus() != DesignStatus::REJECTED) {
            abort(404);
        }

        $this->validateDesign($design);

        return view('frontend/designer.show_rejected')
            ->with(['design' => $design]);
    }

    /**
     * @param StoreDesignRequest $request
     * @return DesignerController
     * @throws \Exception
     */
    public function finalizeDesign(StoreDesignRequest $request)
    {
        $designer = current_user()->getDesigner();

        if ($designer) {
            $data = $request->all();
            $data['designer'] = $designer;

            $design = $this->designService->saveDesignerDesign($data);

            return $this->sendToReviewView($design->getId(), $request->get('type'));
        }

        return abort(404);
    }

    public function editDesign(int $id)
    {
        $design = $this->designService->findOneById($id);

        if ($design->getStatus() != DesignStatus::CREATED) {
            abort(404);
        }

        $this->validateDesign($design);

        if ($design->getSource() === DesignSource::EDITOR) {
            $directory = "images/clipart/";

            $images = glob($directory . "*.jpg");
            $images = array_merge($images, glob($directory . "*.png"));

            if ($design->getType() === DesignType::EDIBLE_PAPER) {
                return view('frontend/designer.design_edible_paper')
                    ->with([
                        'design' => $design,
                        'circularDesignVariant' => $design->getCircularDesignVariant(),
                        'images' => $images,
                    ]);
            } elseif ($design->getType() === DesignType::MUG) {
                return view('frontend/designer.design_mug')
                    ->with([
                        'design' => $design,
                        'images' => $images,
                    ]);
            }


        } else {
            return $this->sendToReviewView($design->getId());
        }
    }

    public function register()
    {
        return view('frontend/designer.register_user_as_designer');
    }

    public function postRegister(Request $request)
    {
        $user = current_user();

        $this->designerService->create($user, $request->get('nickname'));

        return redirect()->route('designer.myDesigns');
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function showDesigns()
    {
        $user = current_user();

        $designer = $user->getDesigner();

        if (!$designer) {
            abort(404);
        }

        $designs = $this->designService->getAllByDesignerAndStatusPaginated($designer, DesignStatus::CREATED);

        return view('frontend/designer.my_designs')->with([
            'designs' => $designs,
        ]);
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function showDesignsInReview()
    {
        $user = current_user();

        $designer = $user->getDesigner();

        if (!$designer) {
            abort(404);
        }

        $designs = $this->designService->getAllByDesignerAndStatusPaginated($designer, DesignStatus::IN_REVIEW);

        return view('frontend/designer.my_designs_in_review')->with([
            'designs' => $designs,
        ]);
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function showDesignsRejected()
    {
        $user = current_user();

        $designer = $user->getDesigner();

        if (!$designer) {
            abort(404);
        }

        $designs = $this->designService->getAllByDesignerAndStatusPaginated($designer, DesignStatus::REJECTED);

        return view('frontend/designer.my_designs_rejected')->with([
            'designs' => $designs,
        ]);
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function showDesignsPublished()
    {
        $user = current_user();

        $designer = $user->getDesigner();

        if (!$designer) {
            abort(404);
        }

        $designs = $this->designService->getAllByDesignerAndStatusPaginated(
            $designer,
            DesignStatus::PUBLISHED
        );

        return view('frontend/designer.my_designs_published')->with([
            'designs' => $designs,
        ]);
    }

    public function create()
    {
        return view('frontend/designer.create_design');
    }

    public function createEdiblePaper()
    {
        $variants = $this->circularDesignVariantService->findAll();

        return view('frontend/designer.create_edible_paper')->with([
            'variants' => $variants,
        ]);
    }

    public function selectEdiblePaper(int $id)
    {
        $variant = $this->circularDesignVariantService->findOneById($id);

        if (!$variant) {
            abort(404);
        }

        return view('frontend/designer.select_edible_paper_variant')->with([
            'variant' => $variant,
        ]);
    }

    public function designMug()
    {
        $directory = "images/clipart/";

        $images = glob($directory . "*.jpg");
        $images = array_merge($images, glob($directory . "*.png"));

        return view('frontend/designer.design_mug', ['images' => $images]);
    }

    public function designEdiblePaper(int $id)
    {
        $circularDesignVariant = $this->circularDesignVariantService->findOneById($id);

        if (!$circularDesignVariant) {
            abort(404);
        }

        $directory = "images/clipart/";

        $images = glob($directory . "*.jpg");
        $images = array_merge($images, glob($directory . "*.png"));

        return view('frontend/designer.design_edible_paper')->with([
            'circularDesignVariant' => $circularDesignVariant,
            'images' => $images,
        ]);
    }

    public function sendToReviewView(
        int $id,
        string $designType = DesignType::EDIBLE_PAPER,
        string $templateImage = null
    ) {
        $design = $this->designService->findOneById($id);

        if ($design->getStatus() != DesignStatus::CREATED) {
            abort(404);
        }

        $this->validateDesign($design);

        $categories = $this->categoryService->findAll(app()->getLocale());
        $occasions = $this->occasionService->findAllOnlyChildren(app()->getLocale());

        $maxPrice = 0;
        if ($designType == DesignType::EDIBLE_PAPER) {
            if ($design->getCircularDesignVariant()) {
                $circularDesignVariant = $design->getCircularDesignVariant();

                foreach ($circularDesignVariant->getDetails() as $detail) {
                    if ($detail->getBasePrice() > $maxPrice) {
                        $maxPrice = $detail->getBasePrice();
                    }
                }
            }
        } else {
            $mugArticle = $this->articleService->findOneForMugsDesign();

            if ($mugArticle) {
                $maxPrice = $mugArticle->getPrice();
            }
        }

        return view('frontend/designer.send_to_review')->with([
            'design' => $design,
            'categories' => $categories,
            'occasions' => $occasions,
            'maxPrice' => $maxPrice,
            'templateImage' => $templateImage,
        ]);
    }

    /**
     * @param SendDesignToReviewRequest $request
     * @param int $id
     * @return DesignerController
     * @throws \Exception
     */
    public function sendDesignToReview(SendDesignToReviewRequest $request, int $id)
    {
        $design = $this->designService->findOneById($id);

        $this->validateDesign($design);

        $data = $request->all();
        $data['image'] = $request->file('image');

        $this->designService->update($design, $request->all());

        return $this->showDesignsInReview();
    }

    private function validateDesign(?Design $design)
    {
        $user = current_user();
        $designer = $user->getDesigner();

        if (!$design || $design->getDesigner()->getId() !== $designer->getId()) {
            abort(404);
        }
    }

    public function downloadTemplate(int $variantId)
    {
        $circularDesignVariant = $this->circularDesignVariantService->findOneById($variantId);

        if (!$circularDesignVariant) {
            abort(404);
        }

        $designer = current_user()->getDesigner();

        if ($designer) {
            $data['designer'] = $designer;
            $data['image_url'] = $circularDesignVariant->getPreviewImage();

            $design = $this->designService->saveDesignerDesign($data);

            $image = $design->getImage();

            return $this->sendToReviewView($design->getId(), $image);
        }
    }
}
