<?php

namespace App\Form;

use App\Entity\Paye;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class EncaissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $daty = new DateTime();
        $results = $daty->format('Y-m-d-H-i-s');
        $krr = explode('-', $results);
        $results = implode("", $krr);
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
            ->add('motifPayement', null, [
                'label' => 'Motif de payement',
            ])
            ->add('refPayement', HiddenType::class, [
                'data' => $results,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Paye::class,
        ]);
    }
}
