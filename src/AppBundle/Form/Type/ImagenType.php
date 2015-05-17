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
            ->add('fichero', 'file', [
                'label' => 'Fotografía',
                'data_class' => null,
                'required' => ($options['nuevo']) ? true : false
            ]);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Imagen',
            'nuevo' => false
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