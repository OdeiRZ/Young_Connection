<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
            ]);
        if ($options['admin']) {
            $builder
                ->add('esActivo', null, [
                    'label' => 'Está Activo',
                    'required' => false,
                ])
                ->add('esAdministrador', null, [
                    'label' => 'Es un Administrador',
                    'required' => false,
                ])
                ->add('esCoordinador', null, [
                    'label' => 'Es un Coordinador',
                    'required' => false,
                ]);
        }
        $builder
            ->add('enviar', 'submit', [
                'label' => 'Guardar cambios',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ]);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Usuario',
            'cascade_validation' => true,
            'admin' => false,
            'coordinador' => false
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