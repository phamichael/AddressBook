<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    public function addAction(Request $request)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setPlainPassword($request->request->get('user')['password']);
        $user->setEnabled(true);
        $form = $this->createForm(new \UserBundle\Form\UserType(), $user);
        if ($form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $userManager->updatePassword($user);
            return $this->redirect($this->generateUrl('home'));
        }
        return $this->render('UserBundle:User:add.html.twig', array('form' => $form->createView()));
    }

    public function editAction(Request $request)
    {
    $user = $this->container->get('security.context')->getToken()->getUser();
    $form = $this->createForm(new \UserBundle\Form\UserEditType(), $user);
    if ($form->handleRequest($request)->isValid())
    {
        $userManager = $this->get('fos_user.user_manager');
        $userManager->updateUser($user);
        return $this->redirect($this->generateUrl('user_account'));
    }
    return $this->render('UserBundle:User:edit.html.twig', array('form' => $form->createView()));
    }
    
    public function accountAction()
    {
    return $this->render('AppBundle:User:account.html.twig');
    }

    public function contactsAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $contacts = $user->getUsers();
        $em = $this->getDoctrine()->getEntityManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        return $this->render('AppBundle:User:contacts.html.twig', array('users' => $users, 'contacts' => $contacts));
    }
}