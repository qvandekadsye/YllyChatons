<?php


namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RaceAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add("RaceName", TextType::class, array('required' => true));
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id')
            ->addIdentifier('raceName', null, [
                'route' => [
                    'name' => 'show'
                ]
        ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('raceName');
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove("delete");
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper->add('raceName');
    }
}
