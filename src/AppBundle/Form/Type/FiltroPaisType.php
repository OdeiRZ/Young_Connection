<?php

namespace AppBundle\Form\Type;

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
                'empty_value' => 'Todos',
                'attr' => ['class' => 'toggle',
                           'name' => 'pais']
            ])
            ->add('enviar', 'submit', [
                'label' => ($options['centro']) ? 'Filtrar Centros' : 'Filtrar Familias',
                'attr' => ['class' => 'btn volver cbutton cbutton--effect-novak-volver']
            ]);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'paises' => null,
            'centro' => false,
            'familia' => false
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