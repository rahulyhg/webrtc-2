<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 14.12.2016
 * Time: 17:25
 */

namespace AppBundle\Form\Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Tests\Extension\Core\Type\RepeatedTypeTest;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

/**
 * @Security("has_role('ROLE_STUDENT')")
 */
class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $userPassword = new UserPassword();
        $userPassword->message = 'Aktuelles Passwort ist nicht korrekt';

        $builder
            ->add('currentPassword', PasswordType::class, array(
                'attr' => array(
                    'placeholder' => 'Aktuelles Passwort'
                ),
                'mapped' => false,
                'constraints' => array($userPassword),
                'label' => false
            ))
            ->add('newPassword', RepeatedTypeTest::class, array(
                'type' => PasswordType::class,
                'mapped' => false,
                'first_options' => array(
                    'attr' => array(
                        'placeholder' => 'Neues Password'
                    ),
                    'label' => false
                ),
                'second_options' => array(
                    'attr' => array(
                        'placeholder' => 'Neues Passwort bestätigen'
                    ),
                    'label' => false
                ),
                'invalid_message' => 'Die Passwörter stimmen nicht überein',
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'method' => 'PATCH',
            'attr' => array(
                'novalidate'=>'novalidate'
            ),
            'csrf_protection' => false
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_password';
    }

}