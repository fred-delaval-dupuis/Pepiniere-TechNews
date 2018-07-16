<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 29/06/2018
 * Time: 10:44
 */

namespace App\Article;


use App\Entity\Article;
use App\Service\Article\Uploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Workflow\Exception\LogicException;
use Symfony\Component\Workflow\Exception\TransitionException;
use Symfony\Component\Workflow\Registry;

class ArticleRequestHandler
{
    private $em, $articleFactory, $uploader, $workflows;

    /**
     * ArticleRequestHandler constructor.
     * @param EntityManagerInterface $em
     * @param ArticleFactory $articleFactory
     * @param Uploader $uploader
     * @param Registry $workflows
     */
    public function __construct(EntityManagerInterface $em, ArticleFactory $articleFactory, Uploader $uploader, Registry $workflows)
    {
        $this->em = $em;
        $this->articleFactory = $articleFactory;
        $this->uploader = $uploader;
        $this->workflows = $workflows;
    }

    /**
     * Handles an article request
     * @param ArticleRequest $articleRequest
     * @param Article $article
     * @return Article|null
     */
    public function handle(ArticleRequest $articleRequest, Article $article)
    {
        $workflow = $this->workflows->get($articleRequest);

//        dd($workflow->getEnabledTransitions($articleRequest));

        # Workflow management
        try {
            $workflow->apply($articleRequest, 'to_review');
        } catch (LogicException $e) {
            return null;
        }

        // We update the persisted article
        $articleRequest->updateArticle($article);

//        dump($article);

        // if we have an UploadedFile, user wants to update the featured image
        if ($articleRequest->getFeaturedImage() instanceof UploadedFile) {
            // we check if the article already has a featured image
            if (file_exists($this->uploader->getDirectory() . $article->getFeaturedImage()) && is_file($this->uploader->getDirectory() . $article->getFeaturedImage())) {
                // if it exists, we delete it
                unlink($this->uploader->getDirectory() . $article->getFeaturedImage());
            }
            // Sets the new featured image in the article
            $article->setFeaturedImage($articleRequest->getFeaturedImage());
            // Uploads the file
            $this->uploader->upload($article);
        }

//        dump($article);

        $this->em->persist($article);
        $this->em->flush();

        return $article;
    }

    public function getFactory()
    {
        return $this->articleFactory;
    }
}