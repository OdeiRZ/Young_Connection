<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FamiliaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('alumnos', null, [
                'label' => 'Alumno/s',
                'required' => true
            ])
            ->add('direccion', null, [
                'label' => 'Dirección',
                'required' => true
            ])
            ->add('telefono', null, [
                'label' => 'Teléfono',
                'required' => true
            ])
            ->add('tieneMascota', null, [
                'label' => 'Tiene Mascota',
                'required' => false
            ])
            ->add('detallesMascota', 'textarea', [
                'label' => 'Detalles Mascota/s',
                'required' => false
            ])
            ->add('puedeMultiAlumno', null, [
                'label' => 'Posibilidad varios Alumnos',
                'required' => false
            ])
            ->add('puedeCompartirAlumno', null, [
                'label' => 'Puede compartir Alumno',
                'required' => false
            ])
            ->add('detallesCompartirAlumno', 'textarea', [
                'label' => 'Detalles compartir Alumno',
                'required' => false
            ])
            ->add('tieneHabitacionExtra', null, [
                'label' => 'Habitación extra',
                'required' => false
            ])
            ->add('observaciones', 'textarea', [
                'label' => 'Descripcion',
                'required' => false
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
        return 'familia';
    }
}