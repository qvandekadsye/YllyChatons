<?php


namespace AppBundle\DataFixtures;

use AppBundle\Entity\Race;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RaceFixtures extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($index = 1; $index < 21; ++$index) {
            /** @var Race $race */
            $race = new Race();
            $race->setRaceName("Race ".$index);
            $race->setWeight(3*$index." kg");
            $manager->persist($race);
            $this->addReference("race".$index, $race);
        }
        $manager->flush();
    }
}
