<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 02/07/2018
 * Time: 10:37
 */

namespace App\Controller\TechNews;


use App\Form\LoginType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route({
     *     "en": "/login",
     *     "fr": "/connexion"
     * },
     *     name="security_login")
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtil
     * @return Response
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtil)
    {
        // already logged
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        // retrieve the form
        $form = $this->createForm(LoginType::class, [
            'email' => $authenticationUtil->getLastUsername()
        ]);

        // get the login error if there is one
        $error = $authenticationUtil->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtil->getLastUsername();

        return $this->render('security/login.html.twig', [
            'form'  => $form->createView(),
            'error' => $error,
        ]);
    }

}