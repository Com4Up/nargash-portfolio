<?php 
namespace App\Form; 
use App\Entity\User; 
use Symfony\Component\Form\AbstractType; 
use Symfony\Component\Form\FormBuilderInterface; 
use Symfony\Component\OptionsResolver\OptionsResolver; 
use Symfony\Component\Form\Extension\Core\Type\EmailType; 
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\Extension\Core\Type\RepeatedType; 
use Symfony\Component\Form\Extension\Core\Type\PasswordType; 
use Symfony\Component\Form\Extension\Core\Type\HiddenType; 
class EditUserType extends AbstractType 
{ 
    public function buildForm(FormBuilderInterface $builder, array $options) 
    { 
        $builder 
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
            'disabled' => true, 
 
            'type' => PasswordType::class, 
            'first_options'  => array( 
                'label' => false, 
                'attr' => ['class' => 'form-control', 
                        'placeholder' =>'password', 
                        'disabled'=> true, 
                        'hidden' => true, 
                    ],), 
            'second_options' => array( 
                'label' => false, 
                'attr' => ['class' => 'form-control', 
                        'placeholder' =>'repeat password', 
                        'disabled'=> true, 
                        'hidden' => true, 
                    ],), 
        )) 
        ; 
    } 
    public function configureOptions(OptionsResolver $resolver) 
    { 
        $resolver->setDefaults(array( 
            //'data_class' => User::class, 
        )); 
    } 
} 