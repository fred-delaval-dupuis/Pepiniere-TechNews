<?php

namespace App\Controller\TechNews;

use App\Controller\HelperTrait;
use App\Entity\Article;
use App\Article\ArticleRequest;
use App\Article\ArticleRequestHandler;
use App\Entity\Category;
use App\Entity\User;
use App\Form\ArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller
{
    use HelperTrait;

    /**
     * @Route("/article", name="article")
     */
    public function index()
    {
        // Category
        $category = new Category();
        $category
            ->setTitle('Engineering')
            ->setSlug('engineering');

        // User (author)
        $user = new User();
        $user
            ->setFirstName('Frédéric')
            ->setLastName('Delaval-Dupuis')
            ->setEmail('test@test.xyz')
            ->setPassword('test')
            ->setRoles(['AUTHOR_ROLE'])
        ;

        // Article
        $article = new Article();
        $article
            ->setTitle('La Pépinière du 06/18 est formidable !')
            ->setContent('<p>Mais, je me pose des questions...</p>')
            ->setAuthor($user)
            ->setCategory($category)
            ->setSpecial(0)
            ->setSpotlight(1)
            ->setFeaturedImage('3.jpg')
        ;

        $em = $this->getDoctrine()->getManager();

        /*$em->persist($category);
        $em->persist($user);
        $em->persist($article);*/

//        $em->flush();

        $this->addFlash('notice', 'Nouvel article ajouté: ' . $article->getId() . ' | nouvelle catégorie: ' . $category->getTitle() . ' | nouvel utilisateur: ' . $user->getLastName());

        return $this->redirectToRoute('home');
    }

    /**
     * @Route(
     *     "/article/add",
     *     name = "article_add"
     * )
     * @Security("has_role('ROLE_AUTHOR')")
     * @param Request $request
     * @param ArticleRequestHandler $articleRequestHandler
     * @return Response
     * @throws \Exception
     */
    public function addArticle(Request $request, ArticleRequestHandler $articleRequestHandler)
    {
        $articleRequest = new ArticleRequest($this->getUser());

        $form = $this->createForm(ArticleType::class, $articleRequest);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = (new Article())->setAuthor($this->getUser());
            $articleRequestHandler->handle($articleRequest, $article);

            return $this->redirectToRoute('index_article', ['category' => $article->getCategory()->getSlug(), 'slug' => $article->getSlug(), 'id' => $article->getId()]);
        }

        return $this->render('article/article_add.html.twig', array(
            'form'      => $form->createView(),
            'action'    => 'Rédiger',
        ));
    }

    /**
     * @Route(
     *     "/article/edit/{id<\d+>}",
     *     name = "article_edit",
     * )
     * @Security("has_role('ROLE_AUTHOR')")
     * @param Article $article
     * @param Request $request
     * @param ArticleRequestHandler $handler
     * @param Packages $packages
     * @return Response
     * @throws \Exception
     */
    public function editArticle(Article $article, Request $request, ArticleRequestHandler $handler, Packages $packages)
    {
        if (null === $article) {
            $this->addFlash('error', "L'article que vous souhaitez éditer n'existe pas.");
            return $this->redirectToRoute('home');
        }

        if ($article->getAuthor() !== $this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $articleRequest = $handler->getFactory()->createRequestFromArticle($article);

//        dump($articleRequest);

        $form = $this->createForm(ArticleType::class, $articleRequest, ['image_url' => $packages->getUrl('images/product/' . $article->getFeaturedImage())]);

        $form->handleRequest($request);
//        dump($form);

        if ($form->isSubmitted() && $form->isValid()) {
             $handler->handle($articleRequest, $article);

            return $this->redirectToRoute('index_article', ['category' => $article->getCategory()->getSlug(), 'slug' => $article->getSlug(), 'id' => $article->getId()]);
        }

        return $this->render('article/article_edit.html.twig', [
            'form'      => $form->createView(),
            'action'    => 'Editer',
        ]);
    }

}
