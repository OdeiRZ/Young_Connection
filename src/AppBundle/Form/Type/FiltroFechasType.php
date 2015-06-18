<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FiltroFechasType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('desde', 'date', [
                'label' => 'Desde',
                'required' => false,
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => ['class' => 'date',
                           'name' => 'desde']
            ])
            ->add('hasta', 'date', [
                'label' => 'Hasta',
                'required' => false,
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => ['class' => 'date',
                           'name' => 'hasta']
            ])
            ->add('enviar', 'submit', [
                'label' => 'Filtrar Intercambios',
                'attr' => ['class' => 'btn volver cbutton cbutton--effect-novak-volver']
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
        return 'filtroFechas';
    }
}