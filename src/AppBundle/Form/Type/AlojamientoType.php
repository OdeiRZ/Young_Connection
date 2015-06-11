<?php

namespace AppBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AlojamientoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('alumno', null, [
                'label' => 'Alumno/a*',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('a')
                              ->Where('a.esAlumno = 1')
                              ->andWhere('a.esActivo = 1'); },
                'required' => true
            ])
            ->add('familia', null, [
                'label' => 'Familia*',
                'required' => true
            ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Alojamiento'
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'alojamiento';
    }
}