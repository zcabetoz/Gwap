<?php

namespace App\Repository;

use App\Entity\Palabra;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Palabra>
 *
 * @method Palabra|null find($id, $lockMode = null, $lockVersion = null)
 * @method Palabra|null findOneBy(array $criteria, array $orderBy = null)
 * @method Palabra[]    findAll()
 * @method Palabra[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PalabraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Palabra::class);
    }

    public function add(Palabra $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Palabra $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByPalabraCorrecta($palabraForm, $idImagen){
        return $this->getEntityManager()
            ->createQuery('
                SELECT palabras.palabra
                FROM App:Palabra palabras
                WHERE palabras.id_imagen = :id AND palabras.palabra = :palabra
            ')
            ->setParameter('id',$idImagen)
            ->setParameter('palabra', $palabraForm)
            ->setMaxResults(1)
            ->getResult();
    }
//    /**
//     * @return Palabra[] Returns an array of Palabra objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Palabra
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
