<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 28/06/2018
 * Time: 14:51
 */

namespace App\Controller\TechNews;

use App\Form\UserType;
use App\User\UserRequest;
use App\User\UserRequestHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserController extends Controller
{
    /**
     * @Route({
     *     "en": "/register",
     *     "fr": "/inscription"
     * },
     *     name = "register"
     * )
     * @param Request $request
     * @param UserRequestHandler $handler
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request, UserRequestHandler $handler)
    {
        $em = $this->getDoctrine()->getManager();

        $userRequest = new UserRequest();

        $form = $this->createForm(UserType::class, $userRequest);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $handler->registerAsUser($userRequest);

//            $this->addFlash('notice', 'Vous avez bien été enregistré.');
            $this->addFlash('notice', 'Vous avez bien été enregistré.');
            return $this->redirectToRoute('home');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
