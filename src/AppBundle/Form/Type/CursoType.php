<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CursoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('centro', null, [
                'label' => 'Centro*',
                'attr' => [ 'title' => 'Seleccione un elemento de la lista' ],
                'required' => true
            ])
            ->add('descripcion', null, [
                'label' => 'Descripción*',
                'attr' => [ 'title' => 'Debe contener 2 caracteres como mínimo' ],
                'required' => true
            ])
            ->add('familia', null, [
                'label' => 'Familia*',
                'attr' => [ 'title' => 'Debe contener 2 caracteres como mínimo' ],
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
        return 'curso';
    }
}