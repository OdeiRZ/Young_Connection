<?php

namespace AppBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FiltroUsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('usuario', 'entity', [
                'label' => 'Usuarios',
                'required' => false,
                'empty_value' => 'Todos',
                'class' => 'AppBundle\Entity\Usuario',
                'attr' => ['class' => 'toggle',
                           'name' => 'usuario']
            ])
            ->add('enviar', 'submit', [
                'label' => 'Filtrar Mensajes',
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
        return 'filtroUsuarios';
    }
}