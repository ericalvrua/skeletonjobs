<?php

namespace App\Repository;

use App\Entity\UsuariosEmpresasOfertas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UsuariosEmpresasOfertas|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsuariosEmpresasOfertas|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsuariosEmpresasOfertas[]    findAll()
 * @method UsuariosEmpresasOfertas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsuariosEmpresasOfertasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsuariosEmpresasOfertas::class);
    }

    // /**
    //  * @return UsuariosEmpresasOfertas[] Returns an array of UsuariosEmpresasOfertas objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UsuariosEmpresasOfertas
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
