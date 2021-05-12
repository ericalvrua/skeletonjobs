<?php

namespace App\Form;

use App\Entity\Ofertas;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfertasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion')
            ->add('puesto')
            ->add('fecha')
            ->add('tipo')
            ->add('id_empresa', EmpresasType::class)
            ->add('categoria')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ofertas::class,
        ]);
    }
}
