<?php

namespace App\Form;

use App\Entity\Hobbie;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class HobbieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('link')
            ->add('type', ChoiceType::class, [
                'choices'=> array(
                    'video' => 'video',
                    'jeu' => 'jeu',
                    'livre' => 'livre',
                    'Collection' => 'collection',
                ),
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('miniature', ImageType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Hobbie::class,
        ]);
    }
}
