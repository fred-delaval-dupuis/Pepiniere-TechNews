<?php

namespace App\Controller\TechNews;

use App\Article\ArticleWorkflowHandler;
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
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Workflow\Exception\LogicException;
use Symfony\Component\Workflow\Registry;

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

//        $this->addFlash('notice', 'Nouvel article ajouté: ' . $article->getId() . ' | nouvelle catégorie: ' . $category->getTitle() . ' | nouvel utilisateur: ' . $user->getLastName());

        return $this->redirectToRoute('home');
    }

    /**
     * @Route({
     *     "en": "/article/new",
     *     "fr": "/article/ajouter"
     * },
     *     name = "article_add"
     * )
     * @Security("has_role('ROLE_AUTHOR')")
     * @param Request $request
     * @param ArticleRequestHandler $articleRequestHandler
     * @param TranslatorInterface $translator
     * @return Response
     * @throws \Exception
     */
    public function addArticle(Request $request, ArticleRequestHandler $articleRequestHandler, TranslatorInterface $translator)
    {
        $articleRequest = new ArticleRequest($this->getUser());
//        $articleRequest->setStatus(['draft']);

        $form = $this->createForm(ArticleType::class, $articleRequest);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = (new Article())->setAuthor($this->getUser());
            $articleRequestHandler->handle($articleRequest, $article);

            return $this->redirectToRoute('index_article', ['category' => $article->getCategory()->getSlug(), 'slug' => $article->getSlug(), 'id' => $article->getId()]);
        }

        return $this->render('article/article_add.html.twig', array(
            'form'      => $form->createView(),
            'action'    => $translator->trans('Rédiger'),
        ));
    }

    /**
     * @Route({
     *     "en": "/article/edit/{id<\d+>}",
     *     "fr": "/article/modifier/{id<\d+>}"
     * },
     *     name = "article_edit",
     * )
     * @Security("has_role('ROLE_AUTHOR')")
     * @param Article $article
     * @param Request $request
     * @param ArticleRequestHandler $handler
     * @param Packages $packages
     * @param TranslatorInterface $translator
     * @return Response
     * @throws \Exception
     */
    public function editArticle(Article $article, Request $request, ArticleRequestHandler $handler, Packages $packages, TranslatorInterface $translator)
    {
        if (null === $article) {
            $this->addFlash('error', $translator->trans("L'article que vous souhaitez éditer n'existe pas."));
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
            'action'    => $translator->trans('Editer'),
        ]);
    }

    /**
     * @Route({
     *     "fr": "/mes-articles",
     *     "en": "/my-articles"
     *     },
     *     name="article_published"
     * )
     * @Security("has_role('ROLE_AUTHOR')")
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function publishedArticles(TranslatorInterface $translator)
    {
        $author = $this->getUser();

        $articles = $this->getDoctrine()->getRepository(Article::class)->findAuthorArticlesByStatus($author->getId(), 'published');

        return $this->render('article/articles.html.twig', [
            'articles'  => $articles,
            'title'     => $translator->trans('sidebar.article.published', [], 'sidebar'),
        ]);
    }

    /**
     * @Route({
     *     "fr": "/mes-articles/en-attente",
     *     "en": "/my-articles/pending"
     *     },
     *     name="article_pending"
     * )
     * @Security("has_role('ROLE_AUTHOR')")
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function pendingArticles(TranslatorInterface $translator)
    {
        $author = $this->getUser();

        $articles = $this->getDoctrine()->getRepository(Article::class)->findAuthorArticlesByStatus($author->getId(), 'review');

        return $this->render('article/articles.html.twig', [
            'articles' => $articles,
            'title'     => $translator->trans('sidebar.article.pending', [], 'sidebar'),
        ]);
    }

    /**
     * @Route({
     *     "fr": "/les-articles/en-attente-de-validation",
     *     "en": "/articles/pending-approval"
     *     },
     *     name="article_approval"
     * )
     * @Security("has_role('ROLE_EDITOR')")
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function approvalArticles(TranslatorInterface $translator)
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findArticlesByStatus('editor');

        return $this->render('article/articles.html.twig', [
            'articles' => $articles,
            'title'     => $translator->trans('sidebar.article.approval', [], 'sidebar'),
        ]);
    }

    /**
     * @Route({
     *     "fr": "/les-articles/en-attente-de-correction",
     *     "en": "/articles/pending-correction"
     *     },
     *     name="article_corrector"
     * )
     * @Security("has_role('ROLE_CORRECTOR')")
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function correctorArticles(TranslatorInterface $translator)
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findArticlesByStatus('corrector');

        return $this->render('article/articles.html.twig', [
            'articles' => $articles,
            'title'     => $translator->trans('sidebar.article.corrector', [], 'sidebar'),
        ]);
    }

    /**
     * @Route({
     *     "fr": "/les-articles/en-attente-de-publication",
     *     "en": "/articles/pending-publishing"
     *     },
     *     name="article_publisher"
     * )
     * @Security("has_role('ROLE_PUBLISHER')")
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function publisherArticles(TranslatorInterface $translator)
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findArticlesByStatus('publisher');

        return $this->render('article/articles.html.twig', [
            'articles' => $articles,
            'title'     => $translator->trans('sidebar.article.publisher', [], 'sidebar'),
        ]);
    }

    /**
     * @Route(
     *     "workflow/{status}/{id}",
     *     name="article_workflow"
     * )
     * @Security("has_role('ROLE_AUTHOR')")
     * @param string $status
     * @param Article $article
     * @param ArticleWorkflowHandler $awh
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function workflow(string $status, Article $article, ArticleWorkflowHandler $awh, Request $request)
    {
        try {
            $awh->handle($article, $status);
            $this->addFlash('notice', 'Votre article a bien été transmis. Merci.');
        } catch (LogicException $e) {
            $this->addFlash('error', 'Changement de statut impossible.');
        }

        $redirect = $request->get('redirect') ?: 'index';
        return $this->redirectToRoute($redirect);
    }
}
