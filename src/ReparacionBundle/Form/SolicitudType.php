<?php

namespace ReparacionBundle\Form;

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
        $builder->add('solicitudDetalles', 'collection', array(
            'entry_type' => DetalleSolicitudType::class,
            'entry_options' => array('label' => false),
            'allow_add'=>true,
            'allow_delete' => true,
            'by_reference' => false,
        ))
        ->add('clienteString','hidden')
        ->add('observacion');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ReparacionBundle\Entity\Solicitud'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'reparacionbundle_solicitud';
    }


}
