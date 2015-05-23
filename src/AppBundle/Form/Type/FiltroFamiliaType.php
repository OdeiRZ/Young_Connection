<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FiltroFamiliaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('familia', 'choice', [
                'label' => 'Familias',
                'required' => false,
                'choices' => $options['familias'],
                'empty_value' => 'Todas',
                'attr' => ['class' => 'toggle',
                           'name' => 'pais']
            ])
            ->add('enviar', 'submit', [
                'label' => 'Filtrar Cursos',
                'attr' => ['class' => 'btn btn-info']
            ]);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'familias' => null
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'filtroFamilias';
    }
}