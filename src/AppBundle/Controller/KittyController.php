<?php
/**
 * User: quentinvdk
 * Date: 05/10/18
 * Time: 10:01
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Kitty;
use AppBundle\Repository\KittyRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class KittyController extends Controller
{
    protected $kittyRepository;

    public function __construct(KittyRepository $kittyRepository)
    {
        $this->kittyRepository = $kittyRepository;
    }


    /**
     * @param Request $request
     * @Rest\View()
     * @Rest\Get("/kitties")
     * @return array
     */
    public function getKittiesAction()
    {
        return  $this->kittyRepository->findAll();
    }

    /**
     * @param Request $request
     * @Rest\View()
     * @Rest\Get("/kitties/{id}")
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
     * * @Rest\Get("/kitties/")
     */
    public function RedirectToGetKittiesAction()
    {
        return $this->redirectToRoute('get_kitties');
    }
}
