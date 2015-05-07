<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $sexos = array(
            'M' => 'Masculino',
            'F' => 'Femenino'
        );
        $builder
            ->add('nombre', null, [
                'label' => 'Nombre',
                'required' => true
            ])
            ->add('apellidos', null, [
                'label' => 'Apellidos',
                'required' => true
            ])
            ->add('fechaNacimiento', 'date', [
                'label' => 'Fecha de Nacimiento',
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => array('class' => 'date'),
                'required' => false
            ])
            ->add('sexo', 'choice', [
                'choices' => $sexos,
                'label' => 'Sexo',
                'expanded' => true,
                'multiple' => false,
                'required' => true, //'data' => 'valor por defecto'
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