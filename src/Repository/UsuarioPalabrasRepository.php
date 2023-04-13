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

    public function findPalabras($idUsuario, $idImagen, $numeroSala){
        return $this->getEntityManager()
            ->createQuery('
                SELECT palabras.palabras_relacionadas, palabras.resultado_palabra
                FROM App:UsuarioPalabras palabras
                WHERE palabras.id_usuario = :id AND palabras.id_imagen = :idImagen AND palabras.numero_sala =:numSala
            ')
            ->setParameter('id',$idUsuario)
            ->setParameter('idImagen', $idImagen)
            ->setParameter('numSala', $numeroSala)
            ->getResult();
    }

    public function findPalabrasPartidas($numeroSala){
        return $this->getEntityManager()
            ->createQuery('
                SELECT palabras.palabras_relacionadas, palabras.url_imagen, palabras.resultado_palabra, usuario.nombre
                FROM App:UsuarioPalabras palabras
                JOIN palabras.id_usuario usuario
                WHERE palabras.numero_sala =:numSala
            ')
            ->setParameter('numSala', $numeroSala)
            ->getResult();
    }

    public function findByPalabraExiste($palabraForm, $idUsuario, $idImagen, $numeroSala){
        return $this->getEntityManager()
            ->createQuery('
                SELECT palabras.palabras_relacionadas
                FROM App:UsuarioPalabras palabras
                WHERE palabras.palabras_relacionadas = :palabra AND palabras.id_usuario = :id AND palabras.id_imagen = :idImagen AND palabras.numero_sala = :numeroSala
            ')
            ->setParameter('palabra', $palabraForm)
            ->setParameter('id', $idUsuario)
            ->setParameter('idImagen', $idImagen)
            ->setParameter('numeroSala', $numeroSala)
            ->setMaxResults(1)
            ->getResult();
    }

    public function findJugadores(){
        return $this->getEntityManager()
            ->createQuery('
                SELECT DISTINCT usuario.username, usuario.id
                FROM App:UsuarioPalabras palabras
                JOIN palabras.id_usuario usuario
            ')
            ->getResult();
    }
    public function findPalabrasJugador($idJugador, $numeroSala){
        return $this->getEntityManager()
            ->createQuery('
                SELECT palabras.palabras_relacionadas, palabras.resultado_palabra, palabras.id_imagen, palabras.url_imagen
                FROM App:UsuarioPalabras palabras
                WHERE palabras.id_usuario = :id AND palabras.numero_sala = :sala
            ')
            ->setParameter('id', $idJugador)
            ->setParameter('sala', $numeroSala)
            ->getResult();
    }
    public function palabrasCorrectas($idUsuario, $numeroSala){
        return $this->getEntityManager()
            ->createQuery('
            SELECT palabras.palabras_relacionadas
            FROM App:UsuarioPalabras palabras
            WHERE palabras.resultado_palabra = :resultado AND palabras.id_usuario = :id AND palabras.numero_sala = :sala
            ')
            ->setParameter('resultado','CORRECTO')
            ->setParameter('id', $idUsuario)
            ->setParameter('sala', $numeroSala)
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
