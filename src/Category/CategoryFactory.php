<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 29/06/2018
 * Time: 13:19
 */

namespace App\Category;

use App\Entity\Category;

class CategoryFactory
{
    public function createFromCategoryRequest(CategoryRequest $request): Category
    {
        return new Category(
            null,
            $request->getTitle(),
            $request->getSlug(),
            $request->getArticles()
        );
    }
}
