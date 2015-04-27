<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class IdiomaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion', null, [
                'label' => 'Descripción',
                'required' => true
            ])
            ->add('reading', null, [
                'label' => 'Nivel Reading',
                'required' => true
            ])
            ->add('writing', null, [
                'label' => 'Nivel Writing',
                'required' => true
            ])
            ->add('speaking', null, [
                'label' => 'Nivel Speaking',
                'required' => true
            ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'idioma';
    }
}