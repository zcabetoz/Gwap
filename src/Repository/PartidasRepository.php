<?php

namespace App\Repository;

use App\Entity\Partidas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Partidas>
 *
 * @method Partidas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Partidas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Partidas[]    findAll()
 * @method Partidas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartidasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Partidas::class);
    }

    public function add(Partidas $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Partidas $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findBySala(){
        return $this->getEntityManager()
            ->createQuery('
                SELECT partidas.sala
                FROM App:Partidas partidas
            ')
            ->getResult();
    }
    public function findUsuariosSalas($idSala){
        return $this->getEntityManager()
            ->createQuery('
                SELECT usuario.username
                FROM App:Partidas partidas
                JOIN partidas.usuarioId usuario
                WHERE partidas.sala = :id
            ')
            ->setParameter('id', $idSala)
            ->getResult();
    }
    public function findImagen($idSala){
        return $this->getEntityManager()
            ->createQuery('
               SELECT imagen.id
               FROM App:Partidas partidas
               JOIN partidas.imagenesId imagen
               WHERE partidas.sala = :id
            ')
            ->setParameter('id', $idSala)
            ->setMaxResults(1)
            ->getResult();
    }

//    /**
//     * @return Partidas[] Returns an array of Partidas objects
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

//    public function findOneBySomeField($value): ?Partidas
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
