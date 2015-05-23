<?php

namespace AppBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FiltroPaisType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pais', 'choice', [
                'label' => 'Paises',
                'required' => false,
                'choices' => $options['paises'],
                //'expanded' => false,
                'empty_value' => 'Todos',
                'attr' => ['class' => 'toggle',
                           'name' => 'pais']
            ])
            ->add('enviar', 'submit', [
                'label' => 'Filtrar Centros',
                'attr' => ['class' => 'btn btn-info']
            ]);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'paises' => null
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'filtroPaises';
    }
}