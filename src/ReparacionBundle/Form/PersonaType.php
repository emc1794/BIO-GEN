<?php

namespace ReparacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nombre')
        ->add('paterno')
        ->add('materno')
        ->add('ci')
        ->add('fechaNacimiento','birthday')
        ->add('sexo','choice',array('choices'=>array(true=>'Masculino',false=>'Femenino'),'expanded'=>true,'multiple'=>false,'required'=>true))
        ->add('telefono')
        ->add('direccion')
        ->add('email');
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ReparacionBundle\Entity\Persona'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'reparacionbundle_persona';
    }


}
