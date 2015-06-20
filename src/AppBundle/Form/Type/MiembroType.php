<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MiembroType extends AbstractType
{
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
                'label' => 'Fecha de Nacimiento',
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [ 'title' => 'Seleccione la fecha correspondiente',
                            'class' => 'date' ],
                'required' => false
            ])
            ->add('telefono', null, [
                'label' => 'Teléfono',
                'attr' => [ 'title' => 'Debe contener 5 caracteres como mínimo' ],
                'required' => false
            ])
            ->add('correoElectronico', 'email', [
                'label' => 'Correo electrónico',
                'attr' => [ 'title' => 'Debe tener formato de correo electrónico' ],
                'required' => false
            ])
            ->add('sexo', 'choice', [
                'choices' => $sexos,
                'label' => 'Sexo*',
                'expanded' => true,
                'multiple' => false,
                'attr' => [ 'title' => 'Seleccione alguna opción' ],
                'required' => true, //'data' => 'valor por defecto'
            ])
            ->add('tipo', null, [
                'label' => 'Tipo de Miembro*',
                'attr' => [ 'title' => 'Debe contener 2 caracteres como mínimo' ],
                'required' => true
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