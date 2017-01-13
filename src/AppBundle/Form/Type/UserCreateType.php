<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 14.12.2016
 * Time: 17:25
 */

namespace AppBundle\Form\Type;
use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Username'
                ),
                'label' => false
            ))
            ->add('firstname', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Vorname'
                ),
                'label' => false
            ))
            ->add('lastname', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Nachname'
                ),
                'label' => false
            ))
            ->add('title', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Titel'
                ),
                'label' => false
            ))
            ->add('newPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'constraints' => array(
                    new NotBlank(array('message' => "Bitte geben Sie ein Passwort an")),
                    new Regex(array(
                            'pattern' => "/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9!@#$%^&*]{8,1024}$/",
                            'message' => "Das Passwort entspricht nicht den Vorgaben",
                        )
                    )
                ),
                'mapped' => false,
                'first_options' => array(
                    'attr' => array(
                        'placeholder' => 'Passwort'
                    ),
                    'label' => false
                ),
                'second_options' => array(
                    'attr' => array(
                        'placeholder' => 'Passwort bestätigen'
                    ),
                    'label' => false
                ),
                'invalid_message' => 'Die Passwörter stimmen nicht überein',
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
            'validation_groups'  => array('Default', 'Create'),
            'attr' => array(
                'novalidate'=>'novalidate'
            ),
            'csrf_protection' => false
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_user_create';
    }

}