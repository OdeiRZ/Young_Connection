<?php

namespace AppBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GrupoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion', null, [
                'label' => 'Descripción*',
                'attr' => [ 'title' => 'Debe contener 2 caracteres como mínimo' ],
                'required' => true
            ])
            ->add('coordinador', null, [
                'label' => 'Coordinador/a*',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                              ->Where('u.esCoordinador = 1')
                              ->andWhere('u.esActivo = 1'); },
                'attr' => [ 'title' => 'Seleccione un elemento de la lista' ],
                'required' => true,
            ])
            ->add('alojamientos', 'collection', [
                'type'  => new AlojamientoType(),
                'label' => 'Alojamiento/s',
                'required' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
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
            'data_class' => 'AppBundle\Entity\Grupo',
            'cascade_validation' => true,
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'grupo';
    }
}