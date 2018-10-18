<?php

namespace AppBundle\FormHandler;

use AppBundle\Entity\Kitty;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class KittyFormHandler
{
    protected $kittyForm;
    protected $request;
    protected $entityManager;

    /**
     * KittyFormHandler constructor.
     * @param FormInterface $kittyForm
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(FormInterface $kittyForm, EntityManagerInterface $entityManager, Request $request = null)
    {
        $this->kittyForm = $kittyForm;
        $this->request = $request;
        $this->entityManager = $entityManager;
    }

    public function processPost($newKitty)
    {
        $this->kittyForm->submit($this->request->request->all()); // Validation des données
        if ($this->kittyForm->isValid()) {
            $fileInfo = $this->request->files->get('image');
            return $this->addNewKitty($newKitty, $fileInfo);
        } else {
            return $this->kittyForm;
        }
    }

    public function processPut(Kitty $kitty)
    {
        $this->kittyForm->submit($this->request->request->all(), false); // Validation des données
        if ($this->kittyForm->isValid()) {
            $this->entityManager->flush();
            return $kitty;
        } else {
            return $this->kittyForm;
        }
    }

    private function addNewKitty(Kitty $newKitty, $fileInfo = null)
    {
        if ($fileInfo !== null) {
            $media = new Media();
            $media->setProviderName('sonata.media.provider.image');
            $media->setBinaryContent($fileInfo);
            $media->setName($fileInfo->getClientOriginalName());
            $media->setEnabled(true);
            $media->setContext('default');
            $newKitty->setImage($media);
        }
        $this->entityManager->persist($newKitty);
        $this->entityManager->flush();
        return $newKitty;
    }
}
