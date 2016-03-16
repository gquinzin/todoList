<?php

namespace TodoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\httpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;
use TodoBundle\Entity\Task;
use TodoBundle\Form\Type\TaskType;

class TaskController extends Controller
{
    /**
     * @Route("/task/create")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $task = new task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($task);
            $em->flush();

            $this->addFlash(
                'notice',
                'Task added with success'
            );

            return $this->redirect("/");
        }

        return $this->render('TodoBundle:Task:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/task/list")
     */
    public function listAction()
    {
        $tasks = $this->getDoctrine()
            ->getRepository('TodoBundle:Task')
            ->findAll();

        return $this->render('TodoBundle:Task:list.html.twig', array(
            'tasks' => $tasks,
        ));
    }
}
