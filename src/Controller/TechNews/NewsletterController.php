<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 03/07/2018
 * Time: 11:39
 */

namespace App\Controller\TechNews;


use App\Entity\Newsletter;
use App\Form\NewsletterType;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

class NewsletterController extends Controller
{
    /**
     * @Route("/newsletter", name="newsletter")
     * @param Request $request
     * @param LoggerInterface $logger
     * @param TranslatorInterface $translator
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newsletter(Request $request, LoggerInterface $logger, TranslatorInterface $translator)
    {
        $newsletter = new Newsletter();

/*        if ($request->isXmlHttpRequest()) {
            return new Response('is xmlHttpRequest', 200);
        } else {
            return new Response('is NOT xmlHttpRequest', 200);
        }*/

        if ($request->isXmlHttpRequest()) {

            $logger->log('debug', $request->get('email'));

            $email = filter_var($request->get('email'), FILTER_VALIDATE_EMAIL);

            $logger->log('debug', $email);
            $newsletter->setEmail($email);

            $em = $this->getDoctrine()->getManager();
            $em->persist($newsletter);
            $em->flush();

//            $this->addFlash('success', 'Merci pour votre inscription à notre newsletter !');
            $this->addFlash('success', $translator->trans('Merci pour votre inscription à notre newsletter !'));

            return new JsonResponse(json_encode('success'), 200);
        } else {
            $form = $this->createForm(NewsletterType::class, $newsletter, ['action' => $this->generateUrl('newsletter')]);
            return $this->render('newsletter/subscribe.html.twig', [
                'form' => $form->createView(),
            ]);
        }

    }
}