<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Kitty
 * Décrit un chaton
 * @package AppBundle\Entity
 * @ORM\Table(name="Kitty")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\KittyRepository")
 */
class Kitty
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string",nullable=false,length=255)
     * @var string
     */
    protected $name = "";
    /**
     * @ORM\Column(name="birthday",nullable=false, type="date")
     * @var /Date
     * @Assert\NotNull()
     * @Assert\Date()
     */
    protected $birthday;

    /**
     * @var boolean
     * @ORM\Column(name="issterilized", nullable=false, type="boolean", options={"default" : 0} )
     */
    protected $isSterilized = '';

    /**
     * @var string
     * @ORM\Column(name="specialSign", nullable=true, type="text")
     */
    protected $specialSign;

    /**
     * @ORM\OneToOne(targetEntity="\Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"}, fetch="LAZY")
     * @var \Application\Sonata\MediaBundle\Entity\Media
     */
    protected $image;


    /**
     * @ORM\ManyToOne(targetEntity="Race",inversedBy="kitties")
     * @ORM\JoinColumn(name="race_id", referencedColumnName="id", nullable=false)
     * @var Race
     * @Assert\NotNull()
     */
    protected $race;


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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param mixed $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * @return bool
     */
    public function isSterilized(): bool
    {
        return $this->isSterilized;
    }

    /**
     * @param bool $isSterilized
     */
    public function setIsSterilized(bool $isSterilized): void
    {
        $this->isSterilized = $isSterilized;
    }

    /**
     * @return string
     */
    public function getSpecialSign(): ?string
    {
        return $this->specialSign;
    }

    /**
     * @param string $specialSign
     */
    public function setSpecialSign(string $specialSign): void
    {
        $this->specialSign = $specialSign;
    }



    /**
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param \Application\Sonata\MediaBundle\Entity\Media $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }



    /**
     * @return Race
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * @param Race $race
     */
    public function setRace($race)
    {
        $this->race = $race;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
