<?php


namespace AppBundle\DataFixtures;

use AppBundle\Entity\Kitty;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class KittyFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($index = 1; $index < 21; ++$index) {
            /** @var Kitty $kitty */
            $kitty = new Kitty();
            $kitty->setName("chat ".$index);
            $kitty->setIsSterilized(true);
            $kitty->setBirthday(new \DateTime());
            $race = $this->getReference("race".$index);
            $kitty->setRace($race);

            $manager->persist($kitty);
        }
        $manager->flush();
    }


    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return array(RaceFixtures::class);
    }
}
