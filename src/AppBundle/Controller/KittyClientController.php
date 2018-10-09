<?php
/**
 * User: quentinvdk
 * Date: 08/10/18
 * Time: 15:35
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Kitty;
use AppBundle\Form\KittyType;
use AppBundle\Repository\KittyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller pour le côté client
 * @package AppBundle\Controller
 */
class KittyClientController extends AbstractController
{
    protected $kittyRepository;
    protected $entityManager;

    public function __construct(KittyRepository $kittyRepository, EntityManagerInterface $entityManager)
    {
        $this->kittyRepository = $kittyRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Request $request
     * @return string
     * @Route(name="add_kitty",path="/kitty/add", methods={"GET", "POST"})
     */
    public function newKittyAction(Request $request)
    {
        $newKitty = new Kitty();
        $kittyForm = $this->createForm(KittyType::class, $newKitty);
        $kittyForm->handleRequest($request);
        if ($kittyForm->isSubmitted() && $kittyForm->isValid()) {
            $this->entityManager->persist($newKitty);
            $this->entityManager->flush();

        }
        return $this->render('Kitty/addKitty.html.twig',array('form' =>$kittyForm->createView()));


    }

}