<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ReportLogosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('setShowLogoJD',CheckboxType::class, [
                'label'=>false,
                'help'=>'Mostrar logo de JD',
                'attr' => [
                    'class' => 'col-md-2',
                ],
            ])

            ->add('file', VichImageType::class, array(
                'label' => 'Imágen (jpeg/png)',
                'required' => false,
                'download_link' => true, // not mandatory, default is true
                'attr' => [
                    'class' => 'col-md-4',
                ],
            ))

        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\ReportLogo',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_resource';
    }
}
