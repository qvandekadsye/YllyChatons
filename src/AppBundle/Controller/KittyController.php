<?php
/**
 * User: quentinvdk
 * Date: 05/10/18
 * Time: 10:01
 */

namespace AppBundle\Controller;

use AppBundle\Repository\KittyRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class KittyController extends Controller
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
     * @Rest\View()
     * @Rest\Get("/api/kitties")
     * @return array
     */
    public function getKittiesAction()
    {
        return  $this->kittyRepository->findAll();
    }

    /**
     * @param Request $request
     * @Rest\View()
     * @Rest\Get("/api/kitties/{id}")
     * @return Object |JsonResponse
     */
    public function getKittyAction(Request $request)
    {
        $kitty =  $this->kittyRepository->find($request->get('id'));
        if (empty($kitty)) {
            return new JsonResponse(array('message' => 'Kitty not found'), Response::HTTP_NOT_FOUND);
        }
        return $kitty;
    }

    /**
     * * @Rest\Get("/api/kitties/")
     */
    public function redirectToGetKittiesAction()
    {
        return $this->redirectToRoute('get_kitties');
    }

    /**
     * @param Request $request
     * @Rest\View()
     * @Rest\Delete("/api/kitties/{id}")
     *
     * @return JsonResponse
     */
    public function deleteKittyAction(Request $request)
    {
        $kitty = $this->kittyRepository->find($request->get('id'));
        if (empty($kitty)) {
            return new JsonResponse(array('message' => 'Kitty not found'), Response::HTTP_NOT_FOUND);
        }
        $this->entityManager->remove($kitty);
        $this->entityManager->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
