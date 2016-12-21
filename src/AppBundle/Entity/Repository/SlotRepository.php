<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Meeting;
use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\Slot;

class SlotRepository extends EntityRepository
{
    public function findLastAcceptedSlotByMeeting(Meeting $meeting)
    {
        $this->createQueryBuilder('s')
            ->select('s')
            ->where('s.meeting = :meeting')
            ->andWhere('s.status = :status')
            ->orderBy('s.date', 'DESC')
            ->setMaxResults(1)
            ->setParameter('meeting', $meeting)
            ->setParameter('status', 'ACCEPTED')
            ->getQuery()
            ->getOneOrNullResult();
    }
}
