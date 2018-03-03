<?php
namespace EventoOriginal\Core\Services;

use App\Events\DesignApproved;
use App\Events\DesignRejected;
use EventoOriginal\Core\Entities\Article;
use EventoOriginal\Core\Entities\Design;
use EventoOriginal\Core\Entities\Designer;
use EventoOriginal\Core\Entities\Order;
use EventoOriginal\Core\Enums\DesignSource;
use EventoOriginal\Core\Enums\DesignStatus;
use EventoOriginal\Core\Persistence\Repositories\DesignRepository;
use Exception;
use InvalidArgumentException;

class DesignService
{
    private $designRepository;
    private $storageService;
    /**
     * @var CategoryService
     */
    private $categoryService;
    /**
     * @var OccasionService
     */
    private $occasionService;
    /**
     * @var CircularDesignVariantService
     */
    private $circularDesignVariantService;
    /**
     * @var ArticleService
     */
    private $articleService;

    /**
     * DesignService constructor.
     * @param DesignRepository $designRepository
     * @param StorageService $storageService
     * @param CategoryService $categoryService
     * @param OccasionService $occasionService
     * @param CircularDesignVariantService $circularDesignVariantService
     * @param ArticleService $articleService
     */
    public function __construct(
        DesignRepository $designRepository,
        StorageService $storageService,
        CategoryService $categoryService,
        OccasionService $occasionService,
        CircularDesignVariantService $circularDesignVariantService,
        ArticleService $articleService
    ) {
        $this->designRepository = $designRepository;
        $this->storageService = $storageService;
        $this->categoryService = $categoryService;
        $this->occasionService = $occasionService;
        $this->circularDesignVariantService = $circularDesignVariantService;
        $this->articleService = $articleService;
    }

    public function findOneById(int $id)
    {
        return $this->designRepository->findOneById($id);
    }

    /**
     * @param array $data
     * @return Article
     */
    public function saveDesignToBuy(array $data)
    {
        $design = new Design();
        $design->setName(trans('designs.personalized'));
        $design->setDescription('Design to buy');

        if (array_key_exists('variant_id', $data)) {
            $variant = $this->circularDesignVariantService->findOneById(array_get($data, 'variant_id'));
            $design->setCircularDesignVariant($variant);
        }

        if (array_key_exists('json', $data)) {
            $design->setJson(array_get($data, 'json'));

            $img = array_get($data, 'image');

            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            $fileName = uniqid() . 'png';

            file_put_contents($fileName, $fileData);

            $image = $this->storageService->savePicture($fileName, 'designs', 'png');

            unlink($fileName);

            $design->setImage($image);
            $design->setSource(DesignSource::EDITOR);
        }

        $this->designRepository->save($design);

        $article = $this->articleService->createFromDesign($design, Article::STATUS_DRAFT);

        $design->setStatus(DesignStatus::PUBLISHED);

        $this->designRepository->save($design);

        return $article;
    }

    public function saveDesignerDesign(array $data)
    {
        if (array_key_exists('design_id', $data) && !empty(array_get($data, 'design_id'))) {
            $design = $this->findOneById(array_get($data, 'design_id'));
        } else {
            $design = new Design();
            $design->setDesigner($data['designer']);
            $design->setName('Design ' . uniqid());
            $design->setType($data['type']);
        }

        if (array_key_exists('name', $data)) {
            $design->setName(array_get($data, 'name'));
        }

        if (array_key_exists('variant_id', $data)) {
            $variant = $this->circularDesignVariantService->findOneById(array_get($data, 'variant_id'));
            $design->setCircularDesignVariant($variant);
        }

        if (array_key_exists('json', $data)) {
            $design->setJson(array_get($data, 'json'));

            $img = array_get($data, 'image');

            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            $fileName = uniqid() . 'png';

            file_put_contents($fileName, $fileData);

            $image = $this->storageService->savePicture($fileName, 'designs', 'png');

            unlink($fileName);

            $design->setImage($image);
            $design->setSource(DesignSource::EDITOR);
        } elseif (array_key_exists('image', $data)) {
            $imgFile = array_get($data, 'image');

            $image = $this->storageService->savePicture(
                array_get($data, 'image'),
                'designs',
                $imgFile->getClientOriginalExtension()
            );

            $design->setImage($image);
            $design->setSource(DesignSource::TEMPLATE);
        } elseif (array_key_exists('image_url', $data)) {
            $design->setImage(array_get($data, 'image_url'));
            $design->setSource(DesignSource::TEMPLATE);
        } else {
            throw new InvalidArgumentException("Invalid design");
        }

        if (array_key_exists('preview_images', $data)) {
            $previewImages = json_decode(array_get($data, 'preview_images'));

            $images = [];

            foreach ($previewImages as $key => $value) {
                $img = str_replace('data:image/png;base64,', '', $value);
                $img = str_replace(' ', '+', $img);
                $fileData = base64_decode($img);
                $fileName = uniqid() . 'png';

                file_put_contents($fileName, $fileData);

                $image = $this->storageService->savePicture($fileName, 'designs', 'png');

                unlink($fileName);

                $images[$key] = $image;
            }

            $design->setPreviewImages($images);
        }

        $this->designRepository->save($design);

        return $design;
    }

    public function getAllByDesignerPaginated(Designer $designer)
    {
        return $this->designRepository->getAllByDesignerPaginated($designer);
    }

    /**
     * @param Designer $designer
     * @param string $status
     * @return \Illuminate\Pagination\LengthAwarePaginator
     * @throws Exception
     */
    public function getAllByDesignerAndStatusPaginated(Designer $designer, string $status)
    {
        if (!DesignStatus::isValid($status)) {
            throw new Exception("Invalid design status");
        }

        return $this->designRepository->getAllByDesignerAndStatusPaginated($designer, $status);
    }

    public function create(Designer $designer, array $data)
    {
        $design = new Design();

        $design->setDesigner($designer);
        $design->setName(array_get($data, 'name'));

        if (isset($data['json'])) {
            $design->setJson(array_get($data, 'json'));
        }

        if (isset($data['image'])) {
            $image = $this->storageService->savePicture(
                array_get($data, 'image'),
                'designs',
                $data['image']->getClientOriginalExtension()
            );
            $design->setImage($image);
        }

        $design->setDescription(array_get($data, 'description'));
        $design->setStatus(DesignStatus::CREATED);

        $this->designRepository->save($design);

        return $design;
    }

    public function update(Design $design, array $data)
    {
        $design->setName(array_get($data, 'name'));
        $design->setDescription(array_get($data, 'description'));
        $design->setCommission(array_get($data, 'commission'));

        if (isset($data['image'])) {
            $image = $this->storageService->savePicture(
                array_get($data, 'image'),
                'designs',
                $data['image']->getClientOriginalExtension()
            );
            $design->setImage($image);
        }

        $categoryId = array_get($data, 'category_id');
        if ($categoryId) {
            $category = $this->categoryService->findOneById($categoryId, app()->getLocale());
            if ($category) {
                $design->setCategory($category);
            }
        }

        foreach (array_get($data, 'occasions') as $occasionId) {
            $occasion = $this->occasionService->findOneById($occasionId);

            if ($occasion) {
                $design->addOccasion($occasion);
            }
        }

        $design->setStatus(DesignStatus::IN_REVIEW);

        $this->designRepository->save($design);

        return $design;
    }

    public function findAllByStatusPaginated(string $status)
    {
        if (!DesignStatus::isValid($status)) {
            throw new InvalidArgumentException("Invalid design status");
        }

        return $this->designRepository->findAllByStatusPaginated($status);
    }

    public function approve(Design $design)
    {
        if ($design->getStatus() != DesignStatus::IN_REVIEW) {
            throw new Exception("Invalid status to approve");
        }

        $this->articleService->createFromDesign($design);

        $design->setStatus(DesignStatus::PUBLISHED);
        $this->designRepository->save($design);

        event(new DesignApproved($design));

        return $design;
    }

    public function reject(Design $design, string $observation)
    {
        if ($design->getStatus() != DesignStatus::IN_REVIEW) {
            throw new Exception("Invalid status to reject");
        }

        $design->setStatus(DesignStatus::REJECTED);
        $design->setObservation($observation);

        $this->designRepository->save($design);

        event(new DesignRejected($design));

        return $design;
    }

    public function findInOrder(Order $order)
    {
        return $this->designRepository->findInOrder($order);
    }
}
