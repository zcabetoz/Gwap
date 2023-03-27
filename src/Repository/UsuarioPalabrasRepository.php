<?php

namespace App\Repository;

use App\Entity\UsuarioPalabras;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UsuarioPalabras>
 *
 * @method UsuarioPalabras|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsuarioPalabras|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsuarioPalabras[]    findAll()
 * @method UsuarioPalabras[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsuarioPalabrasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsuarioPalabras::class);
    }

    public function add(UsuarioPalabras $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UsuarioPalabras $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findPalabras($idUsuario){
        return $this->getEntityManager()
            ->createQuery('
                SELECT palabras.palabras_relacionadas
                FROM App:UsuarioPalabras palabras
                WHERE palabras.id_usuario = :id
            ')
            ->setParameter('id',$idUsuario)
            ->getResult();
    }

//    /**
//     * @return UsuarioPalabras[] Returns an array of UsuarioPalabras objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UsuarioPalabras
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
