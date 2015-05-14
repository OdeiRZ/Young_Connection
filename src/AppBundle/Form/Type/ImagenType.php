<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImagenType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', 'file', [
                'label' => 'Fichero*',
                'data_class' => null,
                'required' => true
            ])
            ->add('enviar', 'submit', [
                'label' => 'Guardar cambios',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ]);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Imagen',
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'imagen';
    }
}