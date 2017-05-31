<?php
namespace EnviaMovil\Core\Tests\Integration\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use EventoOriginal\Core\Entities\Brand;
use Faker\Factory;
use Faker\ORM\Doctrine\Populator;

class BrandsFixture extends AbstractFixture
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
        $populator->addEntity(Brand::class, 5, [
            'name' => $generator->text(5)
        ]);
        $populator->execute();
    }
}
