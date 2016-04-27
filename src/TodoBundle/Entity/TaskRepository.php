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
    public function getTasksOfTheDay(User $user){
        $start = date('Y-m-d 00:00:00');
        $end = date('Y-m-d 23:59:59');

        $tasks = $this->getTasksBetweenDates($start, $end, $user);

        return $tasks;
    }

    public function getTasksOfTheWeek(User $user){
        $day = date('w');
        $start = date('Y-m-d 00:00:00', strtotime("-" . $day . 'days'));
        $end = date('Y-m-d 23:59:59', strtotime("+" . (6-$day) . 'days'));

        $tasks = $this->getTasksBetweenDates($start, $end, $user);

        return $tasks;
    }

    public function getTasksOfTheMonth(User $user){
        $start = date('Y-m-01 00:00:00');
        $end = date('Y-m-t 23:59:59');

        $tasks = $this->getTasksBetweenDates($start, $end, $user);

        return $tasks;
    }

    private function getTasksBetweenDates($start, $end, $user){
        return $this->createQueryBuilder('t')
            -> where('t.dueDate >= :start')->setParameter('start', $start)
            -> andwhere('t.dueDate <= :end')->setParameter('end', $end)
            -> andwhere('t.user <= :user')->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    public function getTasksByTag($tag, User $user){
        return $this->createQueryBuilder('t')
            ->join('t.tag', 'tag', 'WITH', 'tag.id = :tagid')->setParameter('tagid', $tag)
            ->addSelect('tag')
            ->where('t.user <= :user')->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}