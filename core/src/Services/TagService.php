<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Tag;
use EventoOriginal\Core\Entities\TagTranslation;
use EventoOriginal\Core\Persistence\Repositories\TagRepository;
use Exception;

class TagService
{
    const DEFAULT_LOCALE = 'es';

    private $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function findOneById(int $id, string $locale)
    {
        $tag = $this->tagRepository->findOneById($id, $locale);

        if (!$tag) {
            throw new Exception("This tag doesn't exist");
        }

        return $tag;
    }

    public function findOneByName(string $name, string $locale)
    {
        $tag = $this->tagRepository->findOneByName($name, $locale);

        return $tag;
    }

    public function findAll(string $locale)
    {
        return $this->tagRepository->findAll($locale);
    }

    public function create(string $name)
    {
        $tag = new Tag();
        $tag->setName($name);

        $this->save($tag);

        return $tag;
    }

    public function addTranslation(Tag $tag, string $translatedName, string $locale)
    {
        $tag->addTranslation(new TagTranslation($locale, 'name', $translatedName));
        $this->save($tag);
    }

    public function update(Tag $tag, string $name)
    {
        $tag->setName($name);

        $this->save($tag);

        return $tag;
    }

    public function delete(Tag $tag)
    {
        $this->tagRepository->delete($tag);
    }

    public function save(Tag $tag)
    {
        $this->tagRepository->save($tag);
    }

    public function findByIds(array $ids)
    {
        $tags = [];

        foreach ($ids as $id) {
            $tag = $this->tagRepository->findOneById($id, 'es');
            $tags[] = $tag;
        }

        return $tags;
    }

    public function getByCategories(array $categories, string $locale = 'es')
    {
        return $this->tagRepository->getByCategories($categories, $locale);
    }
}
