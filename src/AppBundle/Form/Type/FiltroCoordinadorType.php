<?php

namespace AppBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FiltroCoordinadorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('coordinador', 'entity', [
                'label' => 'Coordinador/a',
                'required' => false,
                'empty_value' => 'Todos',
                'class' => 'AppBundle\Entity\Usuario',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                              ->Where('u.esCoordinador = 1')
                              ->andWhere('u.esActivo = 1'); },
                'attr' => ['class' => 'toggle',
                           'name' => 'coordinador']
            ])
            ->add('enviar', 'submit', [
                'label' => 'Filtrar Grupos',
                'attr' => ['class' => 'btn btn-info']
            ]);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([

        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'filtroCoordinadores';
    }
}