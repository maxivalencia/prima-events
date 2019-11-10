<?php

namespace App\Form;

use App\Entity\SortieArticle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('refernce')
            ->add('quantiteCommander')
            ->add('quantiteSortie')
            ->add('date')
            ->add('reste')
            ->add('article')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SortieArticle::class,
        ]);
    }
}
