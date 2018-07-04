<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 28/06/2018
 * Time: 15:43
 */

namespace App\Controller;


use Behat\Transliterator\Transliterator;

trait HelperTrait
{
    /**
     * Slugify a text
     * @param $text
     * @return null|string|string[]
     */
    /*public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }*/

    public function slugify($text)
    {
        return Transliterator::transliterate($text);
    }
}