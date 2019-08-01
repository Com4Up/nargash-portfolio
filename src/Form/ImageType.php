<?php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('alt')
           ->add('filename', FileType::class, ['label' => 'Upload the thumbnail'])
        //    ->add('brochure', FileType::class, ['label' => 'Brochure (PDF file)'])

            ;
}

    public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults([
                'data_class' => Image::class,
            ]);
        }

}
