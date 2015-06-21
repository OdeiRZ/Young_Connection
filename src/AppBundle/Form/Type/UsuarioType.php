<?php

namespace AppBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
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
                'attr' => [ 'title' => 'Debe contener 2 caracteres como mínimo sin dígitos' ],
                'required' => true
            ])
            ->add('apellidos', null, [
                'label' => 'Apellidos*',
                'attr' => [ 'title' => 'Debe contener 2 caracteres como mínimo sin dígitos' ],
                'required' => true
            ])
            ->add('fechaNacimiento', 'date', [
                'label' => 'Fecha de Nacimiento*',
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [ 'title' => 'Seleccione la fecha correspondiente',
                            'class' => 'date' ],
                'required' => true
            ])
            ->add('sexo', 'choice', [
                'choices' => $sexos,
                'label' => 'Sexo*',
                'expanded' => true,
                'multiple' => false,
                'attr' => [ 'title' => 'Seleccione alguna opción' ],
                'required' => true, //'data' => 'valor por defecto'
            ])
            ->add('telefono', null, [
                'label' => 'Teléfono',
                'attr' => [ 'title' => 'Debe contener 5 caracteres como mínimo y 30 como máximo' ],
                'required' => false
            ])
            ->add('correoElectronico', 'email', [
                'label' => 'Correo electrónico*',
                'attr' => [ 'title' => 'Debe tener formato de correo electrónico' ],
                'required' => true,
                //'attr' => array('disabled' => ($options['nuevo']) ? false : true)
            ])
            ->add('imagen', 'file', [
                'label' => 'Fotografía',
                'data_class' => null,
                'attr' => [ 'title' => 'Seleccione o no una imágen en formato .jpeg, .gif, .png o .tiff de 2 Mb. máximo' ],
                'required' => false,
                //'required' => ($options['nuevo']) ? true : false
            ]);
        if ($options['admin']) {
            $builder
                ->add('curso', null, [
                    'label' => 'Curso',
                    'attr' => [ 'title' => 'Seleccione o no un elemento de la lista' ],
                    'required' => false
                ]);
        }
        if ($options['alumno'] and !$options['nuevo']) {
            $builder
                ->add('pais', null, [
                    'label' => 'País',
                    'attr' => [ 'title' => 'Debe contener 2 caracteres como mínimo sin dígitos' ],
                    'required' => true
                ])
                ->add('tieneProblemasSalud', null, [
                    'label' => 'Problemas de Salud',
                    'required' => false
                ])
                ->add('detallesProblemasSalud', 'textarea', [
                    'label' => 'Detalles Problemas de Salud',
                    'required' => false
                ])
                ->add('esFumador', null, [
                    'label' => 'Fumador',
                    'required' => false
                ])
                ->add('esBebedor', null, [
                    'label' => 'Bebedor',
                    'required' => false
                ])
                ->add('haViajadoExtranjero', null, [
                    'label' => 'Ha Viajado al Extranjero',
                    'required' => false
                ])
                ->add('detallesViajeExtranjero', 'textarea', [
                    'label' => 'Detalles Viaje Extranjero',
                    'required' => false
                ])
                ->add('preferenciaCompanero', null, [
                    'label' => 'Preferencia de Compañero/a',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                                  ->Where('u.esAlumno = 1')
                                  ->andWhere('u.esActivo = 1'); },
                    'attr' => [ 'title' => 'Seleccione o no algún/os elemento/s de la lista' ],
                    'required' => false
                ])
                ->add('descripcion', 'textarea', [
                    'label' => 'Descripción',
                    'required' => false
                ])
                ->add('idiomas', 'collection', [
                    'type'  => new IdiomaType(),
                    'label' => 'Idioma/s',
                    'required' => false,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ])
                ->add('aficiones', null, [
                    'label' => 'Afición/es',
                    'required' => false,
                    'expanded' => true,
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('a')
                                  ->Where('a.validada = true'); },
                    'attr' => [
                        'class' => 'toggle'
                    ]
                ]);
        }
        if ($options['admin']) {
            $builder
                ->add('pais', null, [
                    'label' => 'País',
                    'attr' => [ 'title' => 'Debe contener 2 caracteres como mínimo sin dígitos' ],
                    'required' => true
                ])
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
                ])
                ->add('esAlumno', null, [
                    'label' => 'Es un Alumno',
                    'required' => false,
                ]);
        }
        if (!$options['nuevo']) {
            $builder
                ->add('enviar', 'submit', array(
                    'label' => 'Guardar cambios',
                    'attr' => array('class' => 'btn crear cbutton cbutton--effect-novak-crear')
                ));
            if (!$options['admin']) {
                $builder
                    ->add('oldPassword', 'password', array(
                        'label' => 'Contraseña antigua*',
                        'required' => false,
                        'mapped' => false,
                        'attr' => [ 'title' => 'Introduce tu contraseña actual' ],
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
                    'attr' => [ 'title' => 'Introduce tu nueva contraseña' ],
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
                    'label' => 'Repita nueva contraseña*',
                    'attr' => [ 'title' => 'Repite tu nueva contraseña' ]
                )
            ))
            ->add('cambiarPassword', 'submit', array(
                'label' => (!$options['nuevo']) ? 'Guardar los cambios y cambiar la contraseña' : 'Guardar cambios',
                'attr' => array('class' => 'btn crear cbutton cbutton--effect-novak-crear'),
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
            'alumno' => false,
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