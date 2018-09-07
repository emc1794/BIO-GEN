<?php

namespace SolicitudBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SolicitudType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('pacienteString','hidden')
        ->add('observacion','textarea',array('required'=>false))
        ->add('laboratorio', 'entity', array(
                'class' => 'SolicitudBundle:Laboratorio',
                'expanded'=>true,
                'multiple'=>true,
                'group_by' => function($choiceValue) {
                    return $choiceValue->getCategoria()->getNombre();
                },
            ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SolicitudBundle\Entity\Solicitud'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'solicitudbundle_solicitud';
    }


}
