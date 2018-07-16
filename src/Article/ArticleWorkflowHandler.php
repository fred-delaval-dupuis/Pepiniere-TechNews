<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 16/07/2018
 * Time: 16:45
 */

namespace App\Article;


use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Workflow\Exception\LogicException;
use Symfony\Component\Workflow\Registry;

class ArticleWorkflowHandler
{
    /**
     * @var Registry
     */
    private $workflows;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * ArticleWorkflowHandler constructor.
     * @param Registry $workflows
     * @param EntityManagerInterface $em
     * @param SessionInterface $session
     */
    public function __construct(Registry $workflows, EntityManagerInterface $em)
    {
        $this->workflows = $workflows;
        $this->em = $em;
    }

    public function handle(Article $article, string $status)
    {
        $workflow = $this->workflows->get($article);

        $workflow->apply($article, $status);
        $this->em->flush();

        if ($workflow->can($article, 'to_be_published')) {
            $workflow->apply($article, 'to_be_published');
            $this->em->flush();
        }
    }
}