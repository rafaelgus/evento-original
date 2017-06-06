<?php
namespace EventoOriginal\Core\Tests\Integration\Services;

use EventoOriginal\Core\Services\TagService;
use EventoOriginal\Core\Tests\Integration\BaseTest;
use Exception;

class TagServiceTest extends BaseTest
{
    /**
     * @var TagService
     */
    private $tagService;

    public function setUp()
    {
        parent::setUp();

        $this->tagService = $this->getService('Tag');
    }

    public function testFindByNonExistentId()
    {
        $this->expectException(Exception::class);
        $this->tagService->findOneById(999999999999, 'es');
    }

    public function testCreate()
    {
        $name = 'Rellena';

        $tag = $this->tagService->create($name);

        $this->assertNotNull($tag->getId());
        $this->assertEquals($name, $tag->getName());
    }

    public function testAddTranslation()
    {
        $name = 'Rellena';
        $translatedName = 'Stuffed';

        $tag = $this->tagService->create($name);
        $this->assertEquals($name, $tag->getName());

        $this->tagService->addTranslation($tag, $translatedName, 'en');

        $translatedTag = $this->tagService->findOneById($tag->getId(), 'en');

        $this->assertEquals($translatedName, $translatedTag->getName());
    }

    public function testFindOneById()
    {
        $name = 'Rellena';

        $tag = $this->tagService->create($name);

        $tagSearched = $this->tagService->findOneById($tag->getId(), 'es');

        $this->assertEquals($tag->getId(), $tagSearched->getId());
    }

    public function testFindOneByName()
    {
        $name = 'Rellena';

        $this->tagService->create($name);

        $tag = $this->tagService->findOneByName($name, 'es');

        $this->assertEquals($name, $tag->getName());
    }

    public function testUpdate()
    {
        $originalName = 'rellen';

        $tag = $this->tagService->create($originalName);

        $newName = 'Rellena';

        $this->tagService->update($tag, $newName);

        $tagSearched = $this->tagService->findOneById($tag->getId(), 'es');

        $this->assertEquals($newName, $tagSearched->getName());
    }

    public function testDelete()
    {
        $this->expectException(Exception::class);

        $tag = $this->tagService->create('rojo');

        $tagId = $tag->getId();

        $this->tagService->delete($tag);

        $this->tagService->findOneById($tagId, 'es');
    }
}
