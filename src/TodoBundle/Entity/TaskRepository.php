<?php
/**
 * Created by PhpStorm.
 * User: gilles
 * Date: 27/04/16
 * Time: 10:16
 */

namespace TodoBundle\Entity;


use Doctrine\ORM\EntityRepository;

class TaskRepository extends EntityRepository
{
    public function getTasksOfTheDay(){
        $start = date('Y-m-d 00:00:00');
        $end = date('Y-m-d 23:59:59');

        $tasks = $this->getEntityManager()
            ->createQuery(
                "SELECT task FROM TodoBundle:Task task
            WHERE task.dueDate >= '$start' AND task.dueDate <= '$end'"
            )->getResult();

        return $tasks;
    }

    public function getTasksOfTheWeek(){
        $day = date('w');
        $start = date('Y-m-d 00:00:00', strtotime("-" . $day . 'days'));
        $end = date('Y-m-d 23:59:59', strtotime("+" . (6-$day) . 'days'));

        $tasks = $this->getEntityManager()
            ->createQuery(
                "SELECT task FROM TodoBundle:Task task
            WHERE task.dueDate >= '$start' AND task.dueDate <= '$end'"
            )->getResult();
        return $tasks;
    }

    public function getTasksOfTheMonth(){
        $start = date('Y-m-01 00:00:00');
        $end = date('Y-m-t 23:59:59');

        $tasks = $this->getEntityManager()
            ->createQuery(
                "SELECT task FROM TodoBundle:Task task
            WHERE task.dueDate >= '$start' AND task.dueDate <= '$end'"
            )->getResult();
        return $tasks;
    }
}