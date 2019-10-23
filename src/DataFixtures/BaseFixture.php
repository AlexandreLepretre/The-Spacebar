<?php


namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class BaseFixture
 * @package App\DataFixtures
 */
abstract class BaseFixture extends Fixture
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @param ObjectManager $entityManager
     */
    abstract protected function loadData(ObjectManager $entityManager);

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->loadData($manager);
    }

    /**
     * @param string $className
     * @param int $count
     * @param callable $factory
     */
    protected function createMany(string $className, int $count, callable $factory)
    {
        for ($iteration = 0; $iteration < $count; $iteration++) {
            $entity = new $className();
            $factory($entity, $iteration);

            $this->manager->persist($entity);
            // store fr usage later as App\Entity\ClassName_#COUNT#
            $this->addReference($className . '_' . $iteration, $entity);
        }
    }
}