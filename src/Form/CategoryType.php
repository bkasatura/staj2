<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Hotel;
use phpDocumentor\Reflection\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('parentid')
            ->add('title')
            ->add('keywords')
            ->add('description')
            ->add('image',FileType::class,[
                'label' => 'Category Image',

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
            ->add('status')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
            'csrf_protection'=>false,
        ]);
    }
}
