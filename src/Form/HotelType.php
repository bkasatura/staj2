<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Hotel;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use phpDocumentor\Reflection\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HotelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'title',
            ])

            ->add('title')
            ->add('keywords')
            ->add('description')
            ->add('image', FileType::class,[
                'label' => 'Hotel Image',

                'mapped' => false,

                'required'=> false,

                'constraints' => [
                    new File([
                        'maxSize'=>'1024k',
                        'mimeTypes' =>[
                        'image/*',
                    ],
                    'mimeTypesMessage' => 'please upload a valid image file',
                    ])
                ],
            ])

            ->add('star',ChoiceType::class,[
                'choices' => [
                    '1 Star' => '1',
                    '2 Star' => '2',
                    '3 Star' => '3',
                    '4 Star' => '4',
                    '5 Star' => '5',
                ],
            ])

            ->add('address')
            ->add('phone')
            ->add('fax')
            ->add('email')
            ->add('city', ChoiceType::class,[
                'choices'=> [
                    'Nevada' => 'Nevada',
                    'Ankara' => 'Ankara',
                    'Istanbul' => 'Istanbul',
                    'Antalya' => 'Antalya',
                    'Paris' => 'Paris',
                    'Moscow' => 'Moscow',
                    'Barcelona' => 'Barcelona'],
            ])


            ->add('country', ChoiceType::class,[
                'choices' => [
                    'USA' =>'USA',
                    'Turkiye' => 'Turkiye',
                    'Spain'  => 'Spain',
                    'Greece' => 'Greece',
                    'Russia' => 'Russia',
                    'France' => 'France'],
            ])



            ->add('location')
            ->add('detail', CKEditorType::class, array(
                'config' => array(
                    'uiColor' => '#ffffff'
                ),
            ))
            ->add('status', ChoiceType::class,[
                'choices' => [
                 'True' => 'True',
                 'false' => 'false'
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Hotel::class,
        ]);
    }
}
