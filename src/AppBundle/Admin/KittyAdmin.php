<?php
/**
 * Created by PhpStorm.
 * User: quentinvdk
 * Date: 02/10/18
 * Time: 16:45
 */

namespace AppBundle\Admin;


use AppBundle\Entity\Race;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class KittyAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add("name",TextType::class,array('required' => true))
            ->add('birthday',BirthdayType::class,array('required' => false))
            ->add('file',FileType::class,array('required' => false))
            ->add('race',ModelListType::class,array('class' =>Race::class, 'required' =>true));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id');
        $listMapper->addIdentifier('name');
        $listMapper->addIdentifier('birthday');
        $listMapper->addIdentifier('race','string');


    }



}