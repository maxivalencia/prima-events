<?php

namespace App\Form;

use App\Entity\Stock;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class CassureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $daty = new DateTime();
        $results = $daty->format('Y-m-d-H-i-s');
        $krr = explode('-', $results);
        $results = implode("", $krr);
        $builder
            ->add('article')
            ->add('quantite')
            ->add('reference', HiddenType::class, [
                'data' => $results,
            ])
            //->add('dateCommande')
            //->add('dateSortiePrevue')
            //->add('dateSortieEffectif')
            //->add('dateRetourPrevu')
            //->add('dateRetourEffectif')
            //->add('user')
            //->add('mouvement')
            ->add('client')
            //->add('mode')
            //->add('userSortie')
            //->add('userRetour')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }
}
