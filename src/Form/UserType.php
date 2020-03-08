<?php

namespace App\Form;

use App\Entity\User;
use phpDocumentor\Reflection\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            // ->add('roles')
            ->add('roles', ChoiceType::class,[
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'User' => 'ROLE_USER'],
            ])

            ->add('password',PasswordType::class,[
                'mapped' => false,
                'constraints'=> [
                    new NotBlank([
                       'message' => 'Please enter password',
                    ]),

                    new Length([
                        'min' => 6,
                        'minMessage'=>'Your password should be at least {{ limit }} characters',
                        'max' => 4096,
                        ]),
                ],
            ])
            ->add('name')
            ->add('surname')
            ->add('image', FileType::class,[
                'label' => 'Image ',

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
            ->add('status', ChoiceType::class,[
                'choices' => [
                    'True' => 'True',
                    'false' => 'false'
                ],
            ]);

        //roles field data transformer
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    return count($rolesArray)? $rolesArray[0]: null;
                },
                function  ($rolesString) {
                    //transform the string back to array
                    return [$rolesString];
                }
            ));



    }






    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }





}
