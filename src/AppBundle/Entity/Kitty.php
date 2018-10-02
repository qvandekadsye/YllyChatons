<?php
/**
 * Created by PhpStorm.
 * User: quentinvdk
 * Date: 02/10/18
 * Time: 14:07
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

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
    protected $name;
    /**
     * @ORM\Column(name="birthday",nullable=false, type="date")
     * @var /Date
     */
    protected $birthday;

    /**
     * @ORM\Column(name="imageFileName",type="string",nullable=true, length=255)
     * @var string
     */
    protected $imageFileName;

    /**
     * @ORM\ManyToOne(targetEntity="Race",inversedBy="kitties")
     * @var Race
     */
    protected $race;

    protected $file;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return string
     */
    public function getImageFileName()
    {
        return $this->imageFileName;
    }

    /**
     * @param string $imageFileName
     */
    public function setImageFileName($imageFileName)
    {
        $this->imageFileName = $imageFileName;
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

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }


}