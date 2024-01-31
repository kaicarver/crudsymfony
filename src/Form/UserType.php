<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('name')
            ->add('password', RepeatedType::class, [
                "type" => PasswordType::class,
                "attr" => ["class" => "form-control"],
                "first_options" => [
                    "label" => "Mot de passe", 
                    "attr" =>["class" => "form-control" ], 
                    "label_attr" => ["class" => "text-black" ]
                ],
                "second_options" => [
                    "label" => "Mot de passe (verif)", 
                    "attr" =>["class" => "form-control" ], 
                    "label_attr" => ["class" => "text-black" ]],
                ])
            ->add('roles', ChoiceType::class, [
                "multiple" => true,
                "choices" => [
                    "Administrateur" => "ROLE_ADMIN",
                    "Client" => "ROLE_CLIENT",
                ],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
