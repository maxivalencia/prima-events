<?php

namespace App\Form;

use App\Entity\RetourArticle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RetourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantitesortie', null, [
                'disabled' => true,
            ])
            ->add('reference', null, [
                'disabled' => true,
            ])
            ->add('dateRetour', null, [
                'disabled' => true,
            ])
            ->add('quatiteRetourner')
            ->add('cassure')
            ->add('prix', null, [
                'disabled' => true,
            ])
            ->add('reste', null, [
                'disabled' => true,
            ])
            ->add('article', null, [
                'disabled' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RetourArticle::class,
        ]);
    }
}
