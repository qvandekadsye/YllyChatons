<?php


namespace AppBundle\Form;

use AppBundle\Entity\Kitty;
use AppBundle\Entity\Race;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\MediaBundle\Form\Type\MediaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KittyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('required' =>true))
            ->add('birthday', BirthdayType::class, array('required' =>true))
            ->add('image', MediaType::class, array('required' => false, 'provider' => 'sonata.media.provider.image', 'context' => 'default'))
            ->add('race', EntityType::class, array('class' => Race::class, 'required' => true))
            ->add("Envoyer", SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => Kitty::class, 'csrf_protection'  => false));
    }
}
