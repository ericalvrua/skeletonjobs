<?php

namespace App\Form;

use App\Entity\Empresas;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpresasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cif')
            ->add('nombre')
            ->add('pass')
            ->add('correo')
            ->add('telefono')
            ->add('direccion')
            ->add('codigo_postal')
            ->add('pais')
            ->add('provincia')
            ->add('localidad')
            ->add('descripcion')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Empresas::class,
        ]);
    }
}
