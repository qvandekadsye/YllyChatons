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
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class KittyAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add("name", TextType::class, array('required' => true))
            ->add('birthday', BirthdayType::class, array('required' => false))
            ->add('image', MediaType::class, array('required' => false, 'provider' => 'sonata.media.provider.image', 'context' => 'default'))
            ->add('race', ModelListType::class, array('class' =>Race::class, 'required' =>true));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id');
        $listMapper->addIdentifier('name', null, [
            'route' => [
                'name' => 'show'
            ]]);

        $listMapper->addIdentifier('image', null, array('template' =>'@SonataMedia/kitty_list_field.html.twig'));
        $listMapper->addIdentifier('birthday');
        $listMapper->addIdentifier('race', 'string');
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper->add('name');
        $showMapper->add('birthday');
        $showMapper->add('race');
        $showMapper->add('image', null, array('template' =>'@SonataMedia/kitty_show_field.html.twig'));
    }

    public function getExportFields()
    {
        return array('name', 'birthday','image','race');
    }
}
