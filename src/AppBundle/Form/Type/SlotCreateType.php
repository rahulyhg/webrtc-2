<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 14.12.2016
 * Time: 17:25
 */

namespace AppBundle\Form\Type;
use AppBundle\Entity\Slot;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @Security("has_role('ROLE_STUDENT')")
 */
class SlotCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Name'
                ),
                'label' => false
            ))
            ->add('duration', IntegerType::class, array(
                'attr' => array(
                    'placeholder' => 'Name'
                ),
                'label' => false
            ))
            ->add('comment', TextareaType::class, array(
                'attr' => array(
                    'placeholder' => 'Name'
                ),
                'label' => false
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Slot::class,
            'attr' => array(
                'novalidate'=>'novalidate'
            ),
            'csrf_protection' => false
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_slot_create';
    }

}