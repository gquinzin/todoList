<?php
/**
 * Created by PhpStorm.
 * User: gilles
 * Date: 23/03/16
 * Time: 11:29
 */

namespace TodoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\httpFoundation\Request;
use TodoBundle\Entity\Category;
use TodoBundle\Form\Type\CategoryType;

class CategoryController extends Controller
{
    /**
     * @Route("/category/create", name="create_category")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $category = new category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($category);
            $em->flush();

            $this->addFlash(
                'notice',
                'Task added with success'
            );

            return $this->redirect("/");
        }

        return $this->render('TodoBundle:Category:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/category/list", name="list_category")
     */
    public function listAction()
    {
        $categories = $this->getDoctrine()
            ->getRepository('TodoBundle:Category')
            ->findAll();

        return $this->render('TodoBundle:Category:list.html.twig', array(
            'categories' => $categories,
        ));
    }
}