<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CentroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', null, [
                'label' => 'Nombre*',
                'required' => true
            ])
            ->add('ciudad', null, [
                'label' => 'Ciudad*',
                'required' => true
            ])
            ->add('provincia', null, [
                'label' => 'Provincia',
                'required' => false
            ])
            ->add('pais', null, [
                'label' => 'Pais*',
                'required' => true
            ])
            ->add('direccion', null, [
                'label' => 'Dirección*',
                'required' => true
            ])
            ->add('telefono', null, [
                'label' => 'Teléfono*',
                'required' => true
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
        return 'centro';
    }
}