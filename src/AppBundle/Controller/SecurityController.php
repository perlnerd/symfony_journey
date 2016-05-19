<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/auth", name="auth")
     */
    public function authAction(Request $request)
    {
        $authUtil     = $this->get('security.authentication_utils');
        $error        = $authUtil->getLastAuthenticationError();
        $lastUsername = $authUtil->getLastUsername();

        return $this->render(
            'authentication/index.html.twig',
            array(
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }
}
