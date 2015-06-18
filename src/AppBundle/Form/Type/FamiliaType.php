<?php

namespace AppBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FamiliaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $usuario = $options['usuario'];
        $builder
            ->add('descripcion', null, [
                'label' => 'Descripción*',
                'required' => true
            ])
            ->add('direccion', null, [
                'label' => 'Dirección*',
                'required' => true
            ])
            ->add('ciudad', null, [
                'label' => 'Ciudad*',
                'required' => true
            ])
            ->add('provincia', null, [
                'label' => 'Provincia*',
                'required' => true
            ])
            ->add('pais', null, [
                'label' => 'País*',
                'required' => true
            ])
            ->add('telefono', null, [
                'label' => 'Teléfono*',
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
            ->add('miembros', 'collection', [
                'type'  => new MiembroType(),
                'label' => 'Miembro/s',
                'required' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('alumnos', null, [
                'label' => 'Alumno/s Miembro/s*',
                'query_builder' => function(EntityRepository $er) use ($usuario) {
                    return $er->createQueryBuilder('a')
                              ->Where('a.esAlumno = 1')
                              ->andWhere('a.esActivo = 1')
                              //->andWhere('a.familia IS NULL') //deshabilitado este filtro para poder deseleccionar alumnos
                              ->andWhere('a.id != :id_alumno')
                              ->setParameter('id_alumno', $usuario); },
                'required' => false
            ])
            ->add('alumnos', null, [
                'label' => 'Alumno/s Hermano/s',
                'required' => false
            ])
            ->add('observaciones', 'textarea', [
                'label' => 'Observaciones',
                'required' => false
            ])
            ->add('enviar', 'submit', [
                'label' => 'Guardar cambios',
                'attr' => [
                    'class' => 'btn crear cbutton cbutton--effect-novak-crear'
                ]
            ]);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Familia',
            'cascade_validation' => true,
            'usuario' => null
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'familia';
    }
}