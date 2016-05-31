<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Form\UserType;
use AppBundle\Entity\UserAuth as User;

class SignUpController extends Controller
{
    private $sessionHelper;
    private $eventHelper;

    /**
     * @Route("/sign-up", name="sign_up")
     *
     */
    public function signUpAction(Request $request)
    {
        $this->configureHelpers();
        $this->sessionHelper->configureAnonId();
        $this->configureUser();

        $user = new User();
        $form = $this->createForm(new UserType(), $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em      = $this->getDoctrine()->getManager();
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($encoded);
            $em->persist($user);
            $em->flush();
            $this->eventHelper->convertAnonToRegisteredUsers($user->getId(), $this->sessionHelper->getAnonymousId());
            $this->eventHelper->logJourneyEvent(8, $user->getId());

            return $this->redirect($this->generateUrl('auth'));
        }

        $this->eventHelper->logJourneyEvent(7, $this->userId);

        return $this->render('sign-up/index.html.twig', array('form' => $form->createView()));
    }

    /**
     * fetch instances of the event and session helpers.
     * @return Object $this;
     */
    private function configureHelpers()
    {
        $this->eventHelper   = $this->get('app.event.logger');
        $this->sessionHelper = $this->get('app.session.helper')->startSession();
    }

    /**
     * configure user info on routes that can be accessed by both anonymous and authorized users.
     * @return Object $this;
     */
    private function configureUser()
    {
        $this->userId = $this->sessionHelper->getAnonymousId();

        if ($userObj = $this->getUser()) {
            $this->userId = $userObj->getId();
        }

        return $this;
    }
}
