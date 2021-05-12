<?php

namespace App\Repository;

use App\Entity\Ofertas;
use Doctrine\DBAL\Connection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ofertas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ofertas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ofertas[]    findAll()
 * @method Ofertas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfertasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ofertas::class);
    }

    // /**
    //  * @return Ofertas[] Returns an array of Ofertas objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ofertas
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    // Obtiene las 5 ultimas ofertas
    public function ofertasLimite()
    {
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "SELECT * FROM ofertas WHERE borrador = false ORDER BY id DESC LIMIT 6";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Obtiene las ofertas con una busqueda
    public function ofertasBusqueda($busqueda)
    {
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "SELECT * FROM ofertas WHERE descripcion LIKE '%$busqueda%' OR puesto LIKE '%$busqueda%' OR tipo LIKE '%$busqueda%'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Obtiene las ofertas en base a la categoria
    public function ofertasCategorias($categoria)
    {
    $conn = $this->getEntityManager()->getConnection();
    
    $sql = "SELECT * FROM ofertas WHERE categoria_id='$categoria' ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll();
}

    // Obtiene las ofertas que se encuentran entre dos fechas
    public function ofertasFecha($fecha1, $fecha2)
    {
    $conn = $this->getEntityManager()->getConnection();

    $sql = "SELECT * FROM `ofertas` WHERE fecha BETWEEN '$fecha1' AND '$fecha2'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll();
    }

    // Obtiene las ofertas segun su actividad
    public function ofertasActividad($actividad) {
    $conn = $this->getEntityManager()->getConnection();

    $sql = "SELECT * FROM `ofertas` WHERE activo = $actividad";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll();
    }

    //Obtiene las ofertas segun la isla indicada
    public function ofertasLoc($loc) {
        $conn = $this->getEntityManager()->getConnection();
        // Buscamos las ofertas que tienen a las islas en la tabla de islas_ofertas
        $sql = "SELECT * FROM `islas_ofertas` WHERE islas_id = $loc";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    
        $x =  $stmt->fetchAll();

        // Guardamos en un array todas las ofertas
        $array = array();
        for ($i = 0; $i < count($x); $i++) {
        $sql = "SELECT * FROM ofertas WHERE id = ".$x[$i]['ofertas_id'];
            
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $array[$i] = $stmt->fetch();
        }

        return $array;
        }


}