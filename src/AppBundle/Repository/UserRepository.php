<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Query\Expr;

class UserRepository extends EntityRepository {

    public function getUsersByFeatureCode($user, $code) {
        $qb = $this->createQueryBuilder('u')
                ->leftJoin('u.role', 'r')
                ->addSelect('r')
                ->leftJoin('r.features', 'f')
                ->andWhere('u.id = :id')
                ->andWhere('f.code = :code')
                ->setParameter('id', $user->getId())
                ->setParameter('code', $code);
        return $qb->getQuery()->getOneOrNullResult();
    }

}
