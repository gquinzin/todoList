<?php

namespace TodoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\httpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;
use TodoBundle\Entity\Task;
use TodoBundle\Entity\Category;
use TodoBundle\Form\Type\TaskType;

class TaskController extends Controller
{
    /**
     * @Route("/task/create", name="create_task")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $task = new task($this->getUser());
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
     * @Route("/task/list", name="list_task")
     */
    public function listAction()
    {
        $tasks = $this->getDoctrine()
            ->getRepository('TodoBundle:Task')
            ->findByUser(
                $this->getUser()
            );

        return $this->render('TodoBundle:Task:list.html.twig', array(
            'tasks' => $tasks,
        ));
    }

    /**
     * @Route("/task/category/{id}", requirements={"id" = "\d+"}, name="list_task_category")
     */
    public function listByCategoryAction(Request $request)
    {
        $tasks = $this
            ->getDoctrine()
            ->getRepository('TodoBundle:Task')
            ->findByCategory(
                $request->get('id')
            );

        return $this->render('TodoBundle:Task:list.html.twig', array(
            'tasks' => $tasks,
        ));
    }

    /**
     * @Route("/task/tag/{id}", requirements={"id" = "\d+"}, name="list_task_tag")
     */
    public function listByTagAction(Request $request)
    {
        $tasks = $this
            ->getDoctrine()
            ->getRepository('TodoBundle:Task')
            ->getTasksByTag(
                $request->get('id'), $this->getUser()
            );

        return $this->render('TodoBundle:Task:list.html.twig', array(
            'tasks' => $tasks,
        ));
    }

    /**
     * @Route("/task/currentday/", name="list_task_currentday")
     */
    public function listByDayAction(Request $request)
    {
        $tasks = $this
            ->getDoctrine()
            ->getRepository('TodoBundle:Task')
            ->getTasksOfTheDay(
                $this->getUser()
            );

        return $this->render('TodoBundle:Task:list.html.twig', array(
            'tasks' => $tasks,
        ));
    }

    /**
     * @Route("/task/currentweek/", name="list_task_currentweek")
     */
    public function listByWeekAction(Request $request)
    {
        $tasks = $this
            ->getDoctrine()
            ->getRepository('TodoBundle:Task')
            ->getTasksOfTheWeek(
                $this->getUser()
            );

        return $this->render('TodoBundle:Task:list.html.twig', array(
            'tasks' => $tasks,
        ));
    }

    /**
     * @Route("/task/currentmonth/", name="list_task_currentmonth")
     */
    public function listByMonthAction(Request $request)
    {
        $tasks = $this
            ->getDoctrine()
            ->getRepository('TodoBundle:Task')
            ->getTasksOfTheMonth(
                $this->getUser()
            );

        return $this->render('TodoBundle:Task:list.html.twig', array(
            'tasks' => $tasks,
        ));
    }
}
