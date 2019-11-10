<?php

namespace App\Form;

use App\Entity\SortieArticle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\LabelType;

class SortieArticleEditionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('refernce', null, [
                'disabled' => true,
            ])
            ->add('article', null, [
                'disabled' => true,
            ])
            ->add('quantiteCommander', null, [
                'disabled' => true,
            ])
            ->add('quantiteSortie')
            ->add('date', null, [
                'disabled' => true,
            ])
            /* ->add('reste', null, [
                'disabled' => true,
            ]) */
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SortieArticle::class,
        ]);
    }
}
