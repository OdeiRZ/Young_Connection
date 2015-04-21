<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UsuarioType extends AbstractType
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
                'required' => true
            ])
            ->add('correoElectronico', 'email', [
                'label' => 'Correo electrónico',
                'required' => true
            ])
            ->add('password', 'password', [
                'label' => 'Contraseña',
                'required' => true
            ])
            ->add('foto', null, [
                'label' => 'Imágen',
                'required' => false
            ])
            ->add('esActivo', null, [
                'label' => 'Está Activo',
                'required' => false
            ])
            ->add('esAdministrador', null, [
                'label' => 'Es un Administrador',
                'required' => false
            ])
            ->add('esCoordinador', null, [
                'label' => 'Es un Coordinador',
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
        return 'usuario';
    }
}