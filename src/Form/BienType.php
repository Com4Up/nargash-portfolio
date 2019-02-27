<?php

namespace App\Form;

use App\Entity\Bien;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class BienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           //->add('libelle',TextType::class)
            ->add('nbrPieces',IntegerType::class,array(
                'attr' => ['class' => 'validate',
                          // 'placeholder' =>'Nombre entre 1 et 8 ;)',
                           'min' => '1',
                           'max' => '8',
                           'maxlength' => '1',
                           'onKeyDown' => "if(this.value>8){this.value='8';}else if(this.value<0){this.value='1';}",
                           'oninput' => "javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);",
                           'onkeypress' => "return event.charCode >= 48 && event.charCode <= 57",
                        ],
                'label'=> 'Nombre de pièces (entre 1 et 8)',
                ))
            ->add('nbrChambres',IntegerType::class,array(
                'attr' => ['class' => 'form-control blurCheck',
                           'placeholder' =>'Entre 1 et 6 aussi ^^ ',
                           'onblur' => 'showPiece()',
                           'min' => '1',
                           'max' => '6',
                           'maxlength' => '1',
                           'onKeyDown' => "if(this.value>8){this.value='6';}else if(this.value<0){this.value='1';}",
                           'oninput' => "javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);",
                           'onkeypress' => "return event.charCode >= 48 && event.charCode <= 57",
                        ],
                'label'=> 'Nombre de chambres',
                ))
            ->add('surfaceHabitable',IntegerType::class,array(
                'attr' => ['class' => 'form-control',
                           'placeholder' =>'500',
                           'min' => '1',
                           'max' => '500',
                           'maxlength' => '3',
                           'onKeyDown' => "if(this.value>300){this.value='500';}else if(this.value<0){this.value='1';}",
                           'oninput' => "javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);",
                           'onkeypress' => "return event.charCode >= 48 && event.charCode <= 57",
                        ],
                'label'=> 'La surface habitable de votre domicile',
                ))
            ->add('loiCarrez',CheckboxType::class,array(
                'attr' => ['class' => 'form-control',
                           'checked'=> 'checked',
            ],
                'label'=> 'Conformément à la loi carrez',
                ))
            ->add('surfaceTerrain',IntegerType::class,array(
                'attr' => [
                            'class' => 'form-control',
                            'placeholder' =>'3000',
                            'min' => '1',
                            'max' => '3000',
                            'maxlength' => '4',
                            'onKeyDown' => "if(this.value>3000){this.value='3000';}else if(this.value<0){this.value='1';}",
                            'oninput' => "javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);",
                            'onkeypress' => "return event.charCode >= 48 && event.charCode <= 57",  
                        ],
                'label'=> 'Surface de votre terrain',
                ))
            ->add('anneeConstruction',IntegerType::class,array(
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' =>'1950',
                    'min' => '1400',
                    'max' => '2018',
                    'maxlength' => '4',
                    'onblur' => "if(this.value>2018){this.value='2018';}else if(this.value<1400){this.value='1400';}",
                    'oninput' => "javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);",
                    'onkeypress' => "return event.charCode >= 48 && event.charCode <= 57",  
                ],
                'label'=> 'Date de construction de la maison',
                ))
            ->add('consommationEnergie',ChoiceType::class,array(
                'label'=> 'Consommation Energetique',
                'choices'=> array(
                    'A' => 'A',
                    'B' => 'B',
                    'C' => 'C',
                    'D' => 'D',
                    'E' => 'E',
                    'F' => 'F',
                    'G' => 'G'
                ),
                'expanded' => true,
                'multiple' => false,
                ))
            ->add('diagnosticAJour',CheckboxType::class,array(
                'required' => false
            ))
            ->add('infoSup',ChoiceType::class,array(
                'label' =>'Information supp',
                'choices'=> array(
                    'Plain Pied' => 'plain Pied',
                    'Cheminée' => 'cheminée',
                    'Cuisine équipée' => 'cuisine équipée',
                    'Piscine' => 'piscine',
                    'Climatisation' => 'climatisation',
                    'Terrasse' => 'terrasse',
                    'Garage' => 'garage',
                    'Grenier/Comble' => 'grenier/Comble'
                ),
                'expanded' => true,
                'multiple' => true,
                'choice_attr' => function($val, $key, $index) { 
                    // adds a class like attending_yes, attending_no, etc 
                    return ['class' => 'input-field']; 
                }, 
                ))
            ->add('type_chauffage',ChoiceType::class,array(
                'choices'=> array(
                    'Electrique' => 'Electrique',
                    'Gaz' => 'Gaz',
                    'Fuel' => 'Fuel',
                    'Mixte' => 'Mixte',
                    'Autre' => 'Autre',
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true
                ))
            ->add('taxe_fonciere',IntegerType::class)
            ->add('titre',TextType::class)
            ->add('description',TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => Bien::class,
        ]);
    }
}
