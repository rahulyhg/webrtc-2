<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 14.12.2016
 * Time: 17:25
 */

namespace AppBundle\Form\Type;
use AppBundle\Entity\Meeting;
use AppBundle\Entity\Slot;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @Security("has_role('ROLE_PROF')")
 */
class MeetingCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', DateTimeType::class, array(
                'widget' => 'single_text',
                // Format hier für Internationalisierung nachher
                'format' => 'dd.MM.yyyy',
                'invalid_message' => 'Europäisches Datum notwendig (d.m.Y)',
                'attr' => array(
                    'class' => 'input-no-border editable',
                    'disabled' => true
                )
            ))
            ->add('endDate', DateTimeType::class, array(
                'widget' => 'single_text',
                // Format hier für Internationalisierung nachher
                'format' => 'dd.MM.yyyy',
                'invalid_message' => 'Europäisches Datum notwendig (d.m.Y)',
                'attr' => array(
                    'class' => 'input-no-border editable',
                    'disabled' => true
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Meeting::class,
            'attr' => array(
                'novalidate'=>'novalidate'
            ),
            'csrf_protection' => false
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_meeting_create';
    }

}