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
                'attr' => [ 'title' => 'Debe contener 2 caracteres como mínimo' ],
                'required' => true
            ])
            ->add('ciudad', null, [
                'label' => 'Ciudad*',
                'attr' => [ 'title' => 'Debe contener 2 caracteres como mínimo sin dígitos' ],
                'required' => true
            ])
            ->add('provincia', null, [
                'label' => 'Provincia',
                'attr' => [ 'title' => 'Debe contener 2 caracteres como mínimo sin dígitos' ],
                'required' => false
            ])
            ->add('pais', null, [
                'label' => 'Pais*',
                'attr' => [ 'title' => 'Debe contener 2 caracteres como mínimo sin dígitos' ],
                'required' => true
            ])
            ->add('direccion', null, [
                'label' => 'Dirección*',
                'attr' => [ 'title' => 'Debe contener 5 caracteres como mínimo' ],
                'required' => true
            ])
            ->add('telefono', null, [
                'label' => 'Teléfono*',
                'attr' => [ 'title' => 'Debe contener 5 caracteres como mínimo' ],
                'required' => true
            ])
            ->add('enviar', 'submit', [
                'label' => 'Guardar cambios',
                'attr' => [
                    'class' => 'btn crear cbutton cbutton--effect-novak-crear'
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