<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\IsTrue;

class UserRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,array(
                'attr' => ['class' => 'form-control',
                           'placeholder' =>'exemple.test@mail.com'],
                'label'=> 'Email : ',
                ))
            ->add('nom', TextType::class,array(
                'attr' => ['class' => 'form-control',
                            'placeholder' =>'Nom'],
                'label'=> 'Nom : '
                ))
            ->add('prenom', TextType::class,array(
                'attr' => ['class' => 'form-control',
                            'placeholder' =>'Prenom'],
                'label'=> 'Prenom : '
                ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array(
                    'label' => 'Password',
                    'attr' => ['class' => 'form-control',
                            'placeholder' =>'password'],),
                'second_options' => array(
                    'label' => 'Confirmation Password',
                    'attr' => ['class' => 'form-control',
                            'placeholder' =>'repeat password'],),
            ))
            ->add('termsAccepted', CheckboxType::class, array(
                'mapped' => false,
                'constraints' => new IsTrue()))
                ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}
