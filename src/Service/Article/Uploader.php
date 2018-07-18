<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 28/06/2018
 * Time: 16:41
 */

namespace App\Service\Article;

use App\Controller\HelperTrait;
use App\Entity\Article;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Uploader
{
    use HelperTrait;

    private $assetsDir;

    public function __construct($assetsDir)
    {
        $this->assetsDir = $assetsDir;
    }

    public function upload(Article $article)
    {
        // upload
        /** @var UploadedFile $file */
        $file = $article->getFeaturedImage();
        $fileName = self::slugify($article->getTitle()).'.'.$file->guessExtension();

        // moves the file to the directory where images are stored
        $file->move(
            $this->assetsDir,
            $fileName
        );

        $article->setFeaturedImage($fileName);
    }

    public function getDirectory(): string
    {
        return $this->assetsDir;
    }
}
