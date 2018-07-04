<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 27/06/2018
 * Time: 12:33
 */

namespace App\Service\Twig;


use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twig\Extension\AbstractExtension;

class AppExtension extends AbstractExtension
{
    const MAX_LENGTH = 170;

    private $session;
    private $em;

    /**
     * AppExtension constructor.
     * @param EntityManagerInterface $em
     * @param SessionInterface $session
     */
    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->session = $session;
        $this->em = $em;
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