<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 27/06/2018
 * Time: 12:33
 */

namespace App\Service\Twig;


use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig\Extension\AbstractExtension;

class AppExtension extends AbstractExtension
{
    const MAX_LENGTH = 170;

    private $session;
    private $em;

    /**
     * @var User
     */
    private $user;

    /**
     * AppExtension constructor.
     * @param EntityManagerInterface $em
     * @param TokenStorageInterface $tokenStorage
     * @param SessionInterface $session
     */
    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage, SessionInterface $session)
    {
        $this->session = $session;
        $this->em = $em;

        if ($tokenStorage->getToken()) {
            $this->user = $tokenStorage->getToken()->getUser();
        }
    }

    public function getFunctions()
    {
        return [
            new \Twig_Function('getCategories', function() {
                return $this->em->getRepository(Category::class)->findCategoriesHavingArticles();
            }),
            new \Twig_Function('isUserInvited', function() {
                return $this->session->get('showModal');
            }),
            new \Twig_Function('getLocales', function() {

            }),
            new \Twig_Function('pendingArticles', function() {
                return $this->em->getRepository(Article::class)->countAuthorArticlesByStatus($this->user->getId(), 'review');
            }),
            new \Twig_Function('publishedArticles', function() {
                return $this->em->getRepository(Article::class)->countAuthorArticlesByStatus($this->user->getId(), 'published');
            }),
            new \Twig_Function('approvalArticles', function() {
                return $this->em->getRepository(Article::class)->countArticlesByStatus('editor');
            }),
            new \Twig_Function('correctorArticles', function() {
                return $this->em->getRepository(Article::class)->countArticlesByStatus('corrector');
            }),
            new \Twig_Function('publisherArticles', function() {
                return $this->em->getRepository(Article::class)->countArticlesByStatus('publisher');
            }),
        ];
    }

    public function getFilters()
    {
        return [
            new \Twig_Filter(
                'summary',
                function($str) {
                    $str = strip_tags($str);
                    if (strlen($str) > self::MAX_LENGTH) {
                        $str =  substr($str,0, strrpos(substr($str,0,self::MAX_LENGTH), ' ')) . '...';
                    }
                    return $str;

                },
                array('is_safe' => array('html'))
            )
        ];
    }

}