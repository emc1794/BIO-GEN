<?php

namespace SolicitudBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReporteSolicitudType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
              ->add('inicio','date', array('required'=>true,'label'=>'Inicio :','label_attr'=>array('class'=>'col-md-3 col-sm-3 col-xs-3')))
              ->add('fin','date', array('required'=>true,'label'=>'Fin :','label_attr'=>array('class'=>'col-md-3 col-sm-3 col-xs-3')));

    }


}
