<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 14.12.2016
 * Time: 16:04
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Meeting;
use AppBundle\Entity\Slot;
use AppBundle\Entity\User;
use AppBundle\Form\Type\SlotCreateType;
use AppBundle\Form\Type\SlotEditType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Security("has_role('ROLE_USER')")
 */
class SlotController extends Controller
{
    /**
     * @Route("/users/{id}/slots", name="get_user_slots")
     * @Security("has_role('ROLE_STUDENT')")
     * @ParamConverter("user", options={"mapping": {"id": "id"}})
     * @Method("GET")
     */
    public function getUserSlotsAction(User $user)
    {
        if (!$user) throw $this->createNotFoundException();
        if(!$user->hasRole(User::ROLE_STUDENT) || ($user != $this->getUser() && !$this->getUser()->hasRole(User::ROLE_ADMIN))) throw $this->createAccessDeniedException();

        return $this->createApiResponse($user->getSlots(), 200, [], ['Default', 'slot']);
    }

    /**
     * @Route("/meetings/{id}/slots", name="post_meeting_slots")
     * @Security("has_role('ROLE_STUDENT')")
     * @ParamConverter("meeting", options={"mapping": {"id": "id"}})
     * @Method("POST")
     */
    public function postMeetingSlotsAction(Request $request, Meeting $meeting)
    {
        if(!$meeting || $meeting->getStatus() !== Slot::STATUS_ACCEPTED) throw $this->createNotFoundException();

        $slot = new Slot();
        $form = $this->createForm(SlotCreateType::class, $slot);
        $form->handleRequest($request);

        if($form->isValid())
        {
            $slot->setStudent($this->getUser());
            $slot->setMeeting($meeting);
            $slot->setStatus(Slot::STATUS_OPEN);

            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($slot);
            $em->flush();
        }else{
            return $this->createApiResponse(['success' => false, 'form_error' => $form->getErrors(true)]);
        }
        return $this->createApiResponse(['success' => true, 'entity' => $slot->getId(), 'slots' => $this->getUser()->getSlots()], 201, [], ['Default', 'slot']);
    }



    /**
     * @Route("/meetings/{meetingid}/slots/{slotid}", name="patch_meeting_slot")
     * @Security("has_role('ROLE_PROF')")
     * @ParamConverter("meeting", options={"mapping": {"meetingid": "id"}})
     * @ParamConverter("slot", options={"mapping": {"slotid": "id"}})
     * @Method("PATCH")
     */
    public function patchMeetingSlotAction(Request $request, Meeting $meeting, Slot $slot)
    {
        if(!$slot || !$meeting || $slot->getMeeting() != $meeting) throw $this->createNotFoundException();
        if(($meeting->getProfessor() != $this->getUser() && !$this->getUser()->hasRole(User::ROLE_ADMIN))) throw $this->createAccessDeniedException();

        $form = $this->createForm(SlotEditType::class, $slot, ['method' => 'PATCH']);
        $form->handleRequest($request);

        if($form->isValid())
        {
            /** @var EntityManagerInterface $em */
            $em = $this->get('doctrine.orm.entity_manager');
            $startDate = $meeting->getStartDate();

            // set start and endpoint
            /** @var Slot $lastAcceptedSlotDuration */
            $lastAcceptedSlotDuration = $em->getRepository('AppBundle:Slot')
                ->findLastAcceptedSlotByMeeting($meeting);

            if($lastAcceptedSlotDuration)
            {
                $startDate = $lastAcceptedSlotDuration->getDate()->add(new \DateInterval('PT' . $lastAcceptedSlotDuration->getDuration() . 'M'));
            }

            $slot->setDate($startDate);
            $em->persist($slot);
            $em->flush();
        }else{
            return $this->createApiResponse(['success' => false, 'form_error' => $form->getErrors(true)]);
        }
        return $this->createApiResponse(['success' => true, 'entity' => $slot]);
    }
}