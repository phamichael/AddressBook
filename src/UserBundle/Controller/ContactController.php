<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContactController extends Controller
{
    public function addAction(Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $contacts = $user->getUsers();
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        foreach ($users as $key => $value) {
            if (in_array($value, $contacts->toArray()) or $value == $user)
                unset($users[$key]);
        }
        $form = $this->createFormBuilder()->getForm();
        if ($form->handleRequest($request)->isValid())
        {
            $id = $request->request->get('user');
            $contact = $em->getRepository('UserBundle:User')->find($id);
            $user->addUser($contact);
            $em->flush();
            return $this->redirect($this->generateUrl('user_contacts'));
        }
        return $this->render('UserBundle:Contact:add.html.twig', array('users' => $users, 'form' => $form->createView()));
    }
    
    public function deleteAction(Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $contacts = $user->getUsers();
        $form = $this->createFormBuilder()->getForm();
        if ($form->handleRequest($request)->isValid())
        {
            $id = $request->request->get('contact');
            $em = $this->getDoctrine()->getManager();
            $contact = $em->getRepository('UserBundle:User')->find($id);
            $user->removeUser($contact);
            $em->flush();
            return $this->redirect($this->generateUrl('user_contacts'));
        }
        return $this->render('UserBundle:Contact:delete.html.twig', array('contacts' => $contacts, 'form' => $form->createView()));
    }
}