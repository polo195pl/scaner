<?php

namespace App\Form;

use App\Entity\Scan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', TextType::class)
            ->add('photo', TextType::class, [
                'attr' => ['class' => 'd-none hidden']
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-submit']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Scan::class,
        ]);
    }
}
