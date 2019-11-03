<?php

namespace App\Form;

use App\Entity\Paye;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EncaissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('refstock', null, [
                'label' => 'reférence',
            ])
            //->add('datePayement')
            //->add('TVA')
            ->add('montant', null, [
                'label' => 'Montant',
            ])
            //->add('payement')
            ->add('typepayement', null, [
                'label' => 'Mode de payement',
            ])
            //->add('typePayement')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Paye::class,
        ]);
    }
}
