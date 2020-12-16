<?php

namespace App\Form;

use App\Entity\Section;
use App\Entity\SectionReport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SectionReportsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('section',null,[
                'attr'=>[
                    'columns'=>'8',
                ],
                'label'=>'Section'
            ])
            ->add('orderNumber',null,[
                'attr'=>[
                    'columns'=>'4'
                ],
                'label'=>'Order Number'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SectionReport::class,
        ]);
    }
}
