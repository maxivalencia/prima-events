<?php

namespace App\Form;

use App\Entity\RetourArticle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RetourArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantitesortie')
            ->add('reference')
            ->add('dateRetour')
            ->add('quatiteRetourner')
            ->add('cassure')
            ->add('prix')
            ->add('article')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RetourArticle::class,
        ]);
    }
}
