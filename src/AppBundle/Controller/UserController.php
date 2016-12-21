<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 14.12.2016
 * Time: 16:04
 */

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\Type\ChangePasswordType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/users")
 * @Security("has_role('ROLE_USER')")
 */
class UserController extends Controller
{
    /**
     * @Route("/professors", name="get_users_professors")
     * @Security("has_role('ROLE_STUDENT')")
     * @Method("GET")
     */
    public function usersProfessorsAction(Request $request)
    {
        $profs = $this->get('doctrine.orm.entity_manager')->getRepository('AppBundle:User')
            ->findByRole(User::ROLE_PROF);

        return $this->createApiResponse($profs);
    }

    /**
     * @Route("/{id}/change-password", name="patch_user_password")
     * @Security("has_role('ROLE_USER')")
     * @ParamConverter("user", options={"mapping": {"id": "id"}})
     * @Method("PATCH")
     */
    public function patchPasswordAction(Request $request, User $user)
    {
        /** @var User $user */
        if($user != $this->getUser() && !$this->getUser()->hasRole(User::ROLE_ADMIN)) throw $this->createNotFoundException();

        // Check old one
        $form = $this->createForm(ChangePasswordType::class, null, ['method' => 'PATCH']);
        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->get('doctrine.orm.entity_manager');
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $form["newPassword"]->getData());
            $user->setPassword($password);
            $em->persist($user);
            $em->flush();
        }else{
            return $this->createApiResponse(['success' => false, 'form_error' => $form->getErrors(true)]);
        }
        return $this->createApiResponse(['success' => true, 'entity' => $user]);
    }
}