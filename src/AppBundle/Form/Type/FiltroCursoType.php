<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FiltroCursoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('curso', 'entity', [
                'label' => 'Cursos',
                'required' => false,
                'empty_value' => 'Todos',
                'class' => 'AppBundle\Entity\Curso',
                'attr' => ['class' => 'toggle',
                           'name' => 'curso']
            ])
            ->add('enviar', 'submit', [
                'label' => 'Filtrar Alumnos',
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
        return 'filtroCursos';
    }
}