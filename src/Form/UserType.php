<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email')
            //->add('password', PasswordType::class)
            //->add('confirm_password', PasswordType::class)
            // ->add('roles', CollectionType::class, [
            //     'label_format' => "Role d'utilisateur :",
            //     'entry_type' => ChoiceType::class,
            //     'entry_options' => [
            //         'choices' => [
            //             'Utilisateur' => 'ROLE_USER',
            //             'Administrateur' => 'ROLE_ADMIN'
            //         ],
            //         'attr' => [ 'class' => "form-control"]
            //     ]
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
