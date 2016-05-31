<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Form\UserType;
use AppBundle\Entity\Form\PasswordType;
use AppBundle\Entity\UserAuth as User;

class DefaultController extends Controller
{
    /**
     * @param  Resource Symfony\Component\HttpFoundation\Request
     * @return Resource Symfony\Component\HttpFoundation\Response
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->redirect($this->generateUrl('welcome'));
    }

    /**
     * Welcome the logged in user
     * @param  Resource Symfony\Component\HttpFoundation\Request
     * @return Resource Symfony\Component\HttpFoundation\Response
     * @Route("/home/welcome", name="welcome")
     */
    public function welcomeAction(Request $request)
    {
        $user = $this->getUser();

        return $this->render('home/welcome/index.html.twig', $this->fetchTwigParamList($user));
    }

    /**
     * Present edit page to user
     * @param  Resource Symfony\Component\HttpFoundation\Request
     * @return Resource Symfony\Component\HttpFoundation\Response
     * @Route("/edit", name="edit")
     */
    public function editAction(Request $request)
    {
        $twigArray        = array();
        $user             = $this->getUser();
        $formFirstAndLast = $this->createForm(new UserType(), $user);
        $formPassword     = $this->createForm(new PasswordType(), $user);

        $formFirstAndLast->handleRequest($request);
        $formPassword->handleRequest($request);

        if ($formFirstAndLast->isSubmitted() && $formFirstAndLast->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $em->flush();
            
            $twigArray['success']['message1'] = "Success!!";
        }

        if ($formPassword->isSubmitted() && $formPassword->isValid()) {
            $em      = $this->getDoctrine()->getManager();
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($encoded);
            $em->flush();
            
            $twigArray['success']['message2'] = "Success!!";
        }

        $twigArray['formFirstAndLast'] = $formFirstAndLast->createView();
        $twigArray['formPassword']     = $formPassword->createView();

        return $this->render('edit/index.html.twig', $twigArray);
    }
    
    private function fetchTwigParamList($user)
    {
        return array(
            'base_dir'  => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'firstName' => $user->getAuFirstName(),
            'lastName'  => $user->getAuLastName(),
        );
    }
}
