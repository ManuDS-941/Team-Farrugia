<?php

namespace App\Form;

use App\Entity\Accueil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AccueilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('image', FileType::class, [
                //Afficher le champ du formulaire comme non mappé afin que symfony n'essaye pas d'obtenir sa valeur avec son entity
                'mapped' => false,
                // Permet de ne pas retelecharger l'image
                'required' => false,
                // Grace au non mapped on peut alors lui définir les contraintes suivante 
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/gif',
                            'application/pdf',
                            //'application/x-pdf',
                        ],
                        'mimeTypesMessage' => "Télécharger une Image valide svp"
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Accueil::class,
        ]);
    }
}
