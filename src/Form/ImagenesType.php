<?php

namespace App\Form;

use App\Entity\Imagenes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImagenesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imagenUrl', FileType::class,array(
                'label'=>'Seleccionar imagen',
                'required'=>true
            ))
            ->add('descripcion', TextType::class, array(
                'label'=>'Nombre',
                'attr'=>array(
                    'placeholder'=>'Ingrese nombre de la imagen'
                )
            ))
            ->add('categoria', TextType::class, array(
                'label'=>'Categoria',
                'attr'=>array(
                    'placeholder'=>'Ingrese la categoria de la imagen'
                )
            ))
            ->add('guardar', SubmitType::class);
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Imagenes::class,
        ]);
    }
}
