<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Kitty;
use AppBundle\Form\KittyType;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use AppBundle\FormHandler\KittyFormHandler;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class KittyController extends Controller
{
    protected $securityChecker;
    protected $serializer;

    public function __construct(Security $securityChecker)
    {
        $this->securityChecker = $securityChecker;
    }


    /**
     * @param ParamFetcher $paramFetcher
     * @return View
     * @Rest\Get("/api/kitties")
     * @Rest\QueryParam(name="page", nullable=true, default=1,requirements="\d+", description="Définit la page")
     * @Rest\QueryParam(name="perPage", nullable=true, default="2", requirements="\d+", description="Definit le nombre de chat par page")
     * @ApiDoc(description="Find all kitties", resource=true)
     */
    public function getKittiesAction(ParamFetcher $paramFetcher)
    {
        $kittyRepository = $this->get('doctrine')->getManager()->getRepository(Kitty::class);
        $maxResult = $paramFetcher->get('perPage');
        $kittyNumber = $kittyRepository->countAllKitties();
        $numberOfPage = ceil($kittyNumber/$maxResult);
        $kitties = $kittyRepository->findKittiesByPage($paramFetcher->get('page'), $maxResult);
        $context = new Context();
        if ($this->securityChecker->getToken() && $this->securityChecker->isGranted('ROLE_USER')) {
            $context->addGroups(array('User', "sonata_api_read"));
        } else {
            $context->addGroup('Anon');
        }

        $data = array('data' => $kitties, 'meta' => array('pageNumber' =>$numberOfPage, 'perPage' =>$maxResult));//Test
        $view = new View();


        $view
            ->setData($data)
            ->setStatusCode(Response::HTTP_OK)
            ->setContext($context);
        return $view;
    }

    /**
     * @param Kitty $kitty
     * @return Object |JsonResponse
     * @Rest\View()
     * @Rest\Get("/api/kitties/{id}")
     * @ParamConverter()
     * @ApiDoc(description="Obtenir les information d'un chaton en particulier", requirements={
     *  {
     *     "name"="id",
     *     "dataType"="integer",
     *     "requirement"="\d+",
     *     "description"="L'id du chaton à obtenir."
     *   }
     *     })
     */
    public function getKittyAction(Kitty $kitty)
    {
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
     * @param Kitty $kitty
     * @return JsonResponse
     * @Rest\View()
     * @Rest\Delete("/api/kitties/{id}")
     * @ApiDoc(description="Supprime un chaton en particulier", authentication=true, requirements={
     *  {
     *     "name"="id",
     *     "dataType"="integer",
     *     "requirement"="\d+",
     *     "description"="Le chaton à effacer"
     *   }
     *     })
     */
    public function deleteKittyAction(Kitty $kitty)
    {
        $entityManager = $this->get('doctrine')->getManager();
        $entityManager->remove($kitty);
        $entityManager->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @param Request $request
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/api/kitties")
     * @\Sensio\Bundle\FrameworkExtraBundle\Configuration\Security("has_role('ROLE_ADMIN')")
     * @ApiDoc(description="Crée un chaton", authentication=true, requirements={
     *   {
     *     "name" = "name",
     *     "dataType" = "string",
     *     "description" = "Le nom du chaton"
     *   },
     *   {
     *     "name"= "birthday[year]",
     *     "dataType" = "integer",
     *     "requirement" = "\d+",
     *     "description" = "Année de naissance"
     *   },
     *    {
     *     "name"= "birthday[month]",
     *     "dataType" = "integer",
     *     "requirement" = "\d+",
     *     "description" = "mois de naissance"
     *   }
     *    ,
     *     {
     *     "name"= "birthday[day]",
     *     "dataType" = "integer",
     *     "requirement" = "\d+",
     *     "description" = "Jour de naissance"
     *   },
     *      {
     *     "name"= "image",
     *     "dataType" = "File",
     *     "requirement" = "Jpeg | PNG",
     *     "description" = "Image du chaton [non obligatoire]"
     *
     *   },
     *     {
     *     "name"= "race",
     *     "dataType" = "integer",
     *     "requirement" = "Un identifiant d'une entité Race",
     *     "description" = "Designe la race du chat"
     *   }
     *     })
     * @return Kitty|\Symfony\Component\Form\FormInterface
     */
    public function createKittyAction(Request $request)
    {
        $entityManager = $this->get('doctrine')->getManager();
        $newKitty = new Kitty();
        $kittyForm = $this->createForm(KittyType::class, $newKitty);
        $formHandler = new KittyFormHandler($kittyForm, $entityManager, $request);
        return $formHandler->processPost($newKitty);
    }

    /**
     * @param Kitty $kitty
     * @param Request $request
     * @return Kitty|null|object|\Symfony\Component\Form\FormInterface|JsonResponse
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Put("/api/kitties/{id}")
     * @ApiDoc(description="Met à jour un chaton", authentication=true, requirements={
     *     {
     *     "name"="id",
     *     "dataType"="integer",
     *     "requirement"="\d+",
     *     "description"="Le chaton à mettre à jour"
     *   },
     *   {
     *     "name" = "name",
     *     "dataType" = "string",
     *     "description" = "Le nom du chaton"
     *   },
     *   {
     *     "name"= "birthday[year]",
     *     "dataType" = "integer",
     *     "requirement" = "\d+",
     *     "description" = "Année de naissance"
     *   },
     *    {
     *     "name"= "birthday[month]",
     *     "dataType" = "integer",
     *     "requirement" = "\d+",
     *     "description" = "mois de naissance"
     *   }
     *    ,
     *     {
     *     "name"= "birthday[day]",
     *     "dataType" = "integer",
     *     "requirement" = "\d+",
     *     "description" = "Jour de naissance"
     *   },
     *     {
     *     "name"= "race",
     *     "dataType" = "integer",
     *     "requirement" = "Un identifiant d'une entité Race",
     *     "description" = "Designe la race du chat"
     *   }
     *     })
     */
    public function updateKittyAction(Kitty $kitty, Request $request)
    {
        $entityManager = $this->get('doctrine')->getManager();
        $kittyForm = $this->createForm(KittyType::class, $kitty);
        $kittyFormHandler = new KittyFormHandler($kittyForm, $entityManager, $request);
        return $kittyFormHandler->processPost($kitty);
    }
}
