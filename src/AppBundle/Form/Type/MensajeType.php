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
                'required' => true
            ])
            ->add('contenido', 'textarea', [
                'label' => 'Mensaje*',
                'attr' => ['rows' => '8'],
                'required' => true
            ])
            ->add('enviar', 'submit', [
                'label' => 'Guardar cambios',
                'attr' => [
                    'class' => 'btn crear'
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