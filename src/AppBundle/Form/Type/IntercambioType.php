<?php

namespace AppBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IntercambioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaInicio', 'date', [
                'label' => 'Fecha de Inicio*',
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [ 'title' => 'Seleccione la fecha correspondiente',
                            'class' => 'date' ],
                'required' => true
            ])
            ->add('fechaFin', 'date', [
                'label' => 'Fecha de Fin*',
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [ 'title' => 'Seleccione la fecha correspondiente',
                            'class' => 'date' ],
                'required' => true
            ])
            ->add('grupos', null, [
                'label' => 'Grupo/s*',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('g')
                              ->Where('g.intercambio IS NULL'); },    //Deshabilitamos opcion para permitir deseleccionar elementos
                'attr' => [ 'title' => 'Seleccione algún/os elemento/s de la lista' ],
                'required' => true
            ])
            ->add('observaciones', null, [
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
            'data_class' => 'AppBundle\Entity\Intercambio',
            'cascade_validation' => true,
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'intercambio';
    }
}