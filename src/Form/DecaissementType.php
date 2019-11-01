<?php

namespace App\Form;

use App\Entity\Paye;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DecaissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('refstock')
            //->add('datePayement')
            //->add('TVA')
            ->add('montant')
            //->add('payement')
            ->add('typepayement')
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
