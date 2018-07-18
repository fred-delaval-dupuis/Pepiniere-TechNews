<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 29/06/2018
 * Time: 13:23
 */

namespace App\Category;

use Doctrine\ORM\EntityManagerInterface;

class CategoryRequestHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var CategoryFactory
     */
    private $factory;

    /**
     * CategoryRequestHandler constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em, CategoryFactory $factory)
    {
        $this->em = $em;
        $this->factory = $factory;
    }


    public function handle(CategoryRequest $request)
    {
        $category = $this->factory->createFromCategoryRequest($request);

        $this->em->persist($category);
        $this->em->flush();

        return $category;
    }
}
