<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Race
 * Décrit la race du chat
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RaceRepository")
 * @ORM\Table(name="Race")
 */
class Race
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;
    /**
     * @ORM\Column(type="string", nullable=false, length=255)
     * @var string
     * @Assert\NotNull()
     */
    protected $raceName = '';

    /**
     * @ORM\OneToMany(targetEntity="Kitty", cascade={"persist","remove"},mappedBy="race")
     */
    protected $kitties;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * @return string
     */
    public function getRaceName(): ?string
    {
        return $this->raceName;
    }

    /**
     * @param string $raceName
     */
    public function setRaceName($raceName)
    {
        $this->raceName = $raceName;
    }

    public function __toString()
    {
        return $this->getRaceName();
    }
}
