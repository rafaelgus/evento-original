<?php
namespace EventoOriginal\Core\Tests\Integration\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use EventoOriginal\Core\Entities\Tag;
use Faker\Factory;
use Faker\ORM\Doctrine\Populator;

class TagsFixture extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $generator = Factory::create();
        $populator = new Populator($generator, $manager);
        $populator->addEntity(Tag::class, 5, [
            'name' => $generator->text(5)
        ]);
        $populator->execute();
    }
}
