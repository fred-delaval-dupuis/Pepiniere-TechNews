<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 29/06/2018
 * Time: 13:26
 */

namespace App\Controller\TechNews;


use App\Category\CategoryRequest;
use App\Category\CategoryRequestHandler;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends Controller
{
    /**
     * @Route(
     *     "/category/add",
     *     name = "category_add"
     * )
     * @param Request $request
     * @param CategoryRequestHandler $handler
     * @return Response
     */
    public function addCategory(Request $request, CategoryRequestHandler $handler)
    {
        $categoryRequest = new CategoryRequest();
        $form = $this->createForm(CategoryType::class, $categoryRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $handler->handle($categoryRequest);
            $this->addFlash('success', 'La catégorie ' . $category->getTitle() . ' a bien été sauvegardée !');
            return $this->redirectToRoute('index_category', ['category' => $category->getSlug()]);
        }

        return $this->render('category/category_add.html.twig', ['form' => $form->createView()]);
    }
}