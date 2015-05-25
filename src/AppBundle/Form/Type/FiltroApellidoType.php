<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FiltroApellidoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('apellidos', null, [
                'label' => 'Nombre/Apellidos',
                'required' => false,
                'attr' => ['name' => 'apellidos']
            ])
            ->add('enviar', 'submit', [
                'label' => 'Filtrar Usuarios',
                'attr' => ['class' => 'btn btn-info']
            ]);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'apellidos' => null,
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'filtroApellidos';
    }
}