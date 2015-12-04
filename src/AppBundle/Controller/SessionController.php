<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class SessionController extends Controller
{

    /**
     * @Route("/login", name="new_session")
     */
    public function newAction()
    {
        $error = $this->get('security.authentication_utils')
            ->getLastAuthenticationError();
        return $this->render('session/new.html.twig', [
            'error' => $error
        ]);
    }

}