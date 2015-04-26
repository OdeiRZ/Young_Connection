<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

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
            ])
            ->add('enviar', 'submit', [
                'label' => 'Guardar cambios',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'miembro';
    }
}