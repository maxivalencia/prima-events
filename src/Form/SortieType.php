<?php

namespace App\Form;

use App\Entity\Stock;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $daty = new DateTime();
        $results = $daty->format('Y-m-d-H-i-s');
        $krr = explode('-', $results);
        $results = implode("", $krr);
        $builder
            ->add('reference', HiddenType::class, [
                'data' => $results,
            ])
            ->add('article')
            ->add('quantite')
            ->add('client')
            //->add('dateCommande')
            ->add('dateSortiePrevue')
            //->add('dateSortieEffectif')
            ->add('dateRetourPrevu')
            ->add('nbJour', null, [
                'label' => 'nombre de jour',
            ])
            ->add('Location')
            ->add('quantiteLouer')
            //->add('dateRetourEffectif')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }
}
