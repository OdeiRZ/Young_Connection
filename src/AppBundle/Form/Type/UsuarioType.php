<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;

class UsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $sexos = array(
            'M' => 'Masculino',
            'F' => 'Femenino'
        );
        $builder
            ->add('nombre', null, [
                'label' => 'Nombre*',
                'required' => true
            ])
            ->add('apellidos', null, [
                'label' => 'Apellidos*',
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
                'label' => 'Sexo*',
                'expanded' => true,
                'multiple' => false,
                'required' => true, //'data' => 'valor por defecto'
            ])
            ->add('telefono', null, [
                'label' => 'Teléfono*',
                'required' => true
            ])
            ->add('correoElectronico', 'email', [
                'label' => 'Correo electrónico*',
                'required' => true,
                //'attr' => array('disabled' => ($options['nuevo']) ? false : true)
            ])
            ->add('imagen', 'file', [
                'label' => 'Fotografía',
                'data_class' => null,
                'required' => false,
                //'required' => ($options['nuevo']) ? true : false
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
        if (!$options['nuevo']) {
            $builder
                ->add('enviar', 'submit', array(
                    'label' => 'Guardar cambios',
                    'attr' => array('class' => 'btn btn-success')
                ));
            if (!$options['admin']) {
                $builder
                    ->add('oldPassword', 'password', array(
                        'label' => 'Contraseña antigua*',
                        'required' => false,
                        'mapped' => false,
                        'constraints' => new UserPassword(array(
                            'groups' => array('password')
                        ))
                    ));
            }
        }
        $builder
            ->add('newPassword', 'repeated', array(
                'required' => false,
                'type' => 'password',
                'mapped' => false,
                'invalid_message' => 'password.no_match',
                'first_options' => array(
                    'label' => 'Nueva contraseña*',
                    'constraints' => array(
                        new Length(array(
                            'min' => 6,
                            'minMessage' => 'password.min_length',
                            'groups' => array('password')
                        )),
                        new NotNull(array(
                            'groups' => array('password')
                        ))
                    )
                ),
                'second_options' => array(
                    'label' => 'Repita nueva contraseña*'
                )
            ))
            ->add('cambiarPassword', 'submit', array(
                'label' => (!$options['nuevo']) ? 'Guardar los cambios y cambiar la contraseña' : 'Guardar cambios',
                'attr' => array('class' => 'btn btn-success'),
                'validation_groups' => array('Default', 'password')
            ));
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
            'coordinador' => false,
            'nuevo' => false
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'usuario';
    }
}