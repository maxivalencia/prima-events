<?php

namespace App\Form;

use App\Entity\Stock;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('article', null, [
                'attr' => [
                    'class' => 'restante',
                ],
            ])
            ->add('quantite')
            ->add('client')
            ->add('date_evenement', Null, [
                'label' => 'Date de l\'évènement',
                /* 'attr' => [
                    'class' => 'datepicker',
                ], */
            ])
            //->add('dateCommande')
            ->add('dateSortiePrevue')
            //->add('dateSortieEffectif')
            ->add('dateRetourPrevu')
            ->add('nbJour', null, [
                'label' => 'nombre de jour',
            ])
            ->add('remise')
            ->add('Location')
            ->add('quantiteLouer')
            ->add('commentaire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }
}
