<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 05/07/2018
 * Time: 11:16
 */

namespace App\Service\Article\Warmer;

use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmer;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class YamlCacheWarmer extends CacheWarmer
{
    /**
     * @inheritDoc
     */
    public function isOptional()
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function warmUp($cacheDir)
    {
        try {
            $filename = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'articles.yml';
            $articles = Yaml::parseFile($filename)['data'];
            $this->writeCacheFile($cacheDir . 'yaml-article.php', serialize($articles));
        } catch (ParseException $exception) {
            printf('Unable to parse the YAML string: %s', $exception->getMessage());
        }
    }
}
