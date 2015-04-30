<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MiembroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', null, [
                'label' => 'Nombre',
                'required' => true
            ])
            ->add('apellidos', null, [
                'label' => 'Apellidos',
                'required' => true
            ])
            ->add('fechaNacimiento', null, [
                'label' => 'Fecha de Nacimiento',
                'required' => false
            ])
            ->add('telefono', null, [
                'label' => 'Teléfono',
                'required' => false
            ])
            ->add('correoElectronico', 'email', [
                'label' => 'Correo electrónico',
                'required' => false
            ])
            ->add('sexo', null, [
                'label' => 'Sexo',
                'required' => true
            ])
            ->add('tipo', null, [
                'label' => 'Tipo de Miembro',
                'required' => true
            ])
            ->add('familia', null, [
                'label' => 'Familia',
                'required' => true
            ])
            ->add('usuario', null, [
                'label' => 'Usuario',
                'required' => false
            ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Miembro'
        ));
    }

    public function getName()
    {
        return 'miembro';
    }
}