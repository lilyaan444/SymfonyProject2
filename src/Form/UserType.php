<?php

namespace App\Form;

use App\Entity\UserEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm',
                    'placeholder' => 'utilisateur@exemple.com'
                ],
                'label' => 'Adresse email',
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-700']
            ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm',
                    'placeholder' => 'Jean'
                ],
                'label' => 'Prénom',
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-700']
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm',
                    'placeholder' => 'Dupont'
                ],
                'label' => 'Nom',
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-700']
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm'
                ],
                'label' => 'Mot de passe',
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-700']
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN'
                ],
                'multiple' => true,
                'expanded' => true,
                'label' => 'Rôles',
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-700'],
                'choice_attr' => function($choice, $key, $value) {
                    return ['class' => 'rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50'];
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserEntity::class,
        ]);
    }
}