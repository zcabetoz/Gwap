<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, array(
                'label' => 'Usuario',
                'attr' => array(
                    'placeholder' => 'Nombre de usuario'
                )
            ))
            ->add('password', PasswordType::class, array(
                'label' => 'Contraseña',
                'attr' => array(
                    'placeholder' => 'Contraseña'
                )
            ))
            ->add('nombre', TextType::class, array(
                'label' => 'Nombre',
                'attr' => array(
                    'placeholder' => 'Nombre'
                )
            ))
            ->add('sexo', ChoiceType::class, array(
                'choices' => array(
                    'Masculino' => 'Masculino',
                    'Femenino' => 'Femenino'
                ),
                'placeholder' => 'Sexo'
            ))
            ->add('fechaNacimiento', TextType::class, array('label' => 'Fecha de nacimiento'))
            ->add('Registrar', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
