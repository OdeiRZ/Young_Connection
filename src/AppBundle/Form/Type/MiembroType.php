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
            ->add('telefono', null, [
                'label' => 'Teléfono',
                'required' => false
            ])
            ->add('correoElectronico', 'email', [
                'label' => 'Correo electrónico',
                'required' => false
            ])
            ->add('sexo', 'choice', [
                'choices' => $sexos,
                'label' => 'Sexo*',
                'expanded' => true,
                'multiple' => false,
                'required' => true, //'data' => 'valor por defecto'
            ])
            ->add('tipo', null, [
                'label' => 'Tipo de Miembro*',
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