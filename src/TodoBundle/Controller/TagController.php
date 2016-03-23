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
use TodoBundle\Entity\Tag;
use TodoBundle\Form\Type\TagType;

class TagController extends Controller
{
    /**
     * @Route("/tag/create", name="create_tag")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $tag = new tag();
        $form = $this->createForm(TagType::class, $tag);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($tag);
            $em->flush();

            $this->addFlash(
                'notice',
                'Tag added with success'
            );

            return $this->redirect("/");
        }

        return $this->render('TodoBundle:Tag:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/tag/list", name="list_tag")
     */
    public function listAction()
    {
        $tags = $this->getDoctrine()
            ->getRepository('TodoBundle:Tag')
            ->findAll();

        return $this->render('TodoBundle:Tag:list.html.twig', array(
            'tags' => $tags,
        ));
    }
}