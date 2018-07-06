<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 25/06/2018
 * Time: 12:34
 */

namespace App\Controller\TechNews;


use App\Article\ArticlesRepository;
use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\VarDumper\VarDumper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class IndexController extends Controller
{
    /**
     * Page d'accueil de notre site
     * @param ArticlesRepository $repository
     * @param Request $request
     * @return Response
     */
    public function index(ArticlesRepository $repository, Request $request)
    {
//        $repository = $this->getDoctrine()->getRepository(Article::class);

//        dump($repository);

//        dump($repository->findAll());

        //dump($this->getUser()->getLocale());

        return $this->render('index/index.html.twig', [
//            'articles'  => $repository->findAll(),
            'articles'  => $repository->findAll(),
//            'spotlight' => $repository->findSpotlightArticles(),
            'spotlight' => $repository->findSpotlightArticles(),
        ]);
    }

    /**
     * Afficher les articles d'une catégorie
     *
     * @Route({
     *     "en": "/category/{category}/{page}",
     *     "fr": "/categorie/{category}/{page}"
     * },
     *     name = "index_category",
     *     methods = {"GET"},
     *     requirements = {"category" = "\w+", "page" = "\d+"},
     *     defaults = {"page" = 1}
     * )
     * @ParamConverter("category", class="App\Entity\Category", options={"mapping"={"category": "slug"}})
     * @param Category $category
     * @param int $page
     * @return Response
     */
    public function category(Category $category, int $page)
    {
        if (null === $category || $page < 1) {
            //$this->redirectToRoute('home', [], Response::HTTP_MOVED_PERMANENTLY);
            $this->redirectToRoute('home');
        }

        //$cat = $this->getDoctrine()->getRepository(Category::class)->getCategoryAndArticles($category);
        $pagination = $this->getDoctrine()->getRepository(Article::class)->findPaginatedArticles($category, $page, Article::NB_PER_PAGE);

        $nbPages = ceil(count($pagination) / Article::NB_PER_PAGE);

        return $this->render('index/category.html.twig', [
            'category'      => $category,
            'pagination'    => $pagination,
            'nbPages'       => $nbPages,
            'page'          => $page,
        ]);
    }

    /**
     * Afficher un article
     *
     * @Route(
     *     "/{category}/{slug}_{id}.html",
     *     name="index_article",
     *     requirements={
     *          "id"="\d+"
     *     }
     * )
     * @param int $id
     * @param string $slug
     * @param ArticlesRepository $repository
     * @return Response
     */
    public function article(int $id, string $slug, ArticlesRepository $repository)
    {
//        $article = $repository->find($id);
        $article = $repository->findOneBy(['id' => $id, 'slug' => $slug]);

        if (null === $article) {
            //return $this->redirectToRoute('home', [], Response::HTTP_MOVED_PERMANENTLY);
//            return $this->redirectToRoute('home');
        }

        $suggestions = $this->getDoctrine()->getRepository(Article::class)->findArticlesSuggestions($article->getId(), $article->getCategory()->getId());

        return $this->render('index/article.html.twig', [
            'article'       => $article,
            'suggestions'   => $suggestions,
        ]);
    }

    /**
     * Renders the sidebar
     * @param Article|null $article
     * @return Response
     */
    public function sidebar(?Article $article = null)
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findLastFiveArticles();
        $specials = $repo->findSpecialArticles();

        return $this->render('components/_sidebar.html.twig', [
            'articles'  => $articles,
            'specials'  => $specials,
            'article'   => $article,
        ]);
    }
}