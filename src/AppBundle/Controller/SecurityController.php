<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    /**
     * @Route("/auth", name="auth")
     *
     */
    public function authAction(Request $request)
    {
        $authUtil     = $this->get('security.authentication_utils');
        $error        = $authUtil->getLastAuthenticationError();
        $lastUsername = $authUtil->getLastUsername();

        $this->addFlash(
            'target',
            $request->query->get('target', false)
        );

        return $this->render(
            'authentication/index.html.twig',
            array(
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }
}
