<?php

namespace AppBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MensajeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('usuarioDestino', null, [
                'label' => 'Destinatario/a*',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                              ->Where('u.esActivo = 1'); },
                'attr' => [ 'title' => 'Seleccione un elemento de la lista' ],
                'required' => true
            ])
            ->add('contenido', 'textarea', [
                'label' => 'Mensaje*',
                'attr' => [ 'title' => 'Debe contener 1 carácter como mínimo',
                            'rows' => '8'],
                'required' => true
            ])
            ->add('enviar', 'submit', [
                'label' => 'Guardar cambios',
                'attr' => [
                    'class' => 'btn crear cbutton cbutton--effect-novak-crear'
                ]
            ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'mensaje';
    }
}