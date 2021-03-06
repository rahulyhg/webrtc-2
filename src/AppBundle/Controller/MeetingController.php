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
use AppBundle\Form\Type\MeetingCreateType;
use AppBundle\Form\Type\MeetingEditType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/users/{id}/meetings")
 * @Security("has_role('ROLE_USER')")
 */
class MeetingController extends Controller
{
    /**
     * @Route("/professor", name="get_user_meetings_professor")
     * @ParamConverter("user", options={"mapping": {"id": "id"}})
     * @Security("has_role('ROLE_PROF')")
     * @Method("GET")
     */
    public function getUserMeetingsProfessorAction(User $user)
    {
        if (!$user) throw $this->createNotFoundException();
        if(!$user->hasRole(User::ROLE_PROF) || ($user != $this->getUser() && !$this->getUser()->hasRole(User::ROLE_ADMIN))) throw $this->createAccessDeniedException();

        $meetings = $user->getMeetings();
        return $this->createApiResponse($meetings, 200, [], ['Default', 'prof']);
    }

    /**
     * @Route("/student", name="get_user_meetings_student")
     * @ParamConverter("user", options={"mapping": {"id": "id"}})
     * @Security("has_role('ROLE_STUDENT')")
     * @Method("GET")
     */
    public function getUserMeetingsStudentAction(User $user)
    {
        if(!$user) throw $this->createNotFoundException();
        if(!$user->hasRole(User::ROLE_PROF)) throw $this->createAccessDeniedException();

        $meetings = $user->getMeetings();
        return $this->createApiResponse($meetings);
    }

    /**
     * @Route("", name="post_user_meeting")
     * @Security("has_role('ROLE_PROF')")
     * @ParamConverter("meeting", options={"mapping": {"id": "id"}})
     * @Method("POST")
     */
    public function postMeetingAction(Request $request, User $user)
    {
        if(!$user) throw $this->createNotFoundException();
        if(($user != $this->getUser() && !$this->getUser()->hasRole(User::ROLE_ADMIN))) throw $this->createAccessDeniedException();

        $meeting = new Meeting();
        $form = $this->createForm(MeetingCreateType::class, $meeting);
        $form->handleRequest($request);

        if($form->isValid())
        {
            $meeting->setProfessor($user);
            $meeting->setStatus(Slot::STATUS_OPEN);

            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($meeting);
            $em->flush();
        }else{
            return $this->createApiResponse(['success' => false, 'form_error' => $form->getErrors(true)]);
        }
        return $this->createApiResponse(['success' => true, 'entity' => $meeting], 201);
    }

    /**
     * @Route("/{meetingid}", name="patch_user_meeting")
     * @Security("has_role('ROLE_PROF')")
     * @ParamConverter("user", options={"mapping": {"id": "id"}})
     * @ParamConverter("meeting", options={"mapping": {"meetingid": "id"}})
     * @Method("PATCH")
     */
    public function patchMeetingAction(Request $request, User $user, Meeting $meeting)
    {
        if(!$user || !$meeting || $meeting->getProfessor() != $user) throw $this->createNotFoundException();
        if(($user != $this->getUser() && !$this->getUser()->hasRole(User::ROLE_ADMIN))) throw $this->createAccessDeniedException();

        $form = $this->createForm(MeetingEditType::class, $meeting, ['method' => 'PATCH']);
        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->get('doctrine.orm.entity_manager');

            /** @var Slot $slot */
            foreach($meeting->getSlots() as $slot)
            {
                $slot->setStatus(Slot::STATUS_CANCELED);
                $em->persist($slot);
            }
            $em->persist($meeting);
            $em->flush();
        }else{
            return $this->createApiResponse(['success' => false, 'form_error' => $form->getErrors(true)]);
        }
        return $this->createApiResponse(['success' => true, 'entity' => $meeting]);
    }
}