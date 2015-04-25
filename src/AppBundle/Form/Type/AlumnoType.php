<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AlumnoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('usuario', null, [
                'label' => 'Usuario',
                'required' => true
            ])
            ->add('curso', null, [
                'label' => 'Curso',
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
                'required' => false,
            ])
            ->add('descripcion', 'textarea', [
                'label' => 'Descripción',
                'required' => false
            ])
            ->add('idiomas', null, [
                'label' => 'Idioma/s',
                'required' => false,
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
        return 'alumno';
    }
}