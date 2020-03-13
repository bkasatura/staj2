<?php

namespace App\Form\Admin;

use App\Entity\Admin\Room;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class RoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')

            ->add('description')
            ->add('image', FileType::class,[
                'label' => 'Image Gallery',

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
            ->add('price')
            ->add('status', ChoiceType::class,[
                'choices' => [
                    'True' => 'True',
                    'false' => 'false'
                ],
            ])
            ->add('number')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Room::class,
        ]);
    }
}
