<?php

namespace App\Repository;

use App\Entity\Estadisticas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Symfony\Component\VarDumper\Dumper\esc;

/**
 * @extends ServiceEntityRepository<Estadisticas>
 *
 * @method Estadisticas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Estadisticas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Estadisticas[]    findAll()
 * @method Estadisticas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstadisticasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Estadisticas::class);
    }

    public function add(Estadisticas $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Estadisticas $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findJugadores($sala){
        return $this->getEntityManager()
            ->createQuery('
                SELECT estadisticas.id_jugador, estadisticas.nombre_jugador
                FROM App:Estadisticas estadisticas
                WHERE estadisticas.sala_partida = :idSala
            ')
            ->setParameter('idSala', $sala)
            ->getResult();
    }

    public function findUltimaPartida(){
        return $this->getEntityManager()
            ->createQuery('
                SELECT estadisticas.sala_partida
                FROM App:Estadisticas estadisticas
                ORDER BY estadisticas.sala_partida DESC 
            ')
            ->setMaxResults(1)
            ->getResult();
    }

    public function findByPartidasJugadas(){
        return $this->getEntityManager()
            ->createQuery('
                SELECT DISTINCT estadisticas.sala_partida
                FROM App:Estadisticas estadisticas
                WHERE estadisticas.partida_finalizada = :estado
            ')
            ->setParameter('estado',1)
            ->getResult();
    }

    public function findByJugadoresPartidas($numeroSala){
        return $this->getEntityManager()
            ->createQuery('
                SELECT estadisticas.nombre_jugador
                FROM App:Estadisticas estadisticas
                WHERE estadisticas.sala_partida = :sala
            ')
            ->setParameter('sala', $numeroSala)
            ->getResult();
    }

    public function findBYPartidaFinalizada($sala){
        return $this->getEntityManager()
            ->createQuery('
                SELECT estadisticas.id
                FROM App:Estadisticas estadisticas
                WHERE estadisticas.sala_partida = :idSala
            ')
            ->setParameter('idSala', $sala)
            ->getResult();
    }
//    /**
//     * @return Estadisticas[] Returns an array of Estadisticas objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Estadisticas
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
