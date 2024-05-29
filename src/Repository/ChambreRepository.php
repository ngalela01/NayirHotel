<?php

namespace App\Repository;

use App\Entity\Chambre;
use App\Form\SearchData;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Chambre>
 *
 * @method Chambre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chambre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chambre[]    findAll()
 * @method Chambre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChambreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chambre::class);
    }

    //    /**
    //     * @return Chambre[] Returns an array of Chambre objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Chambre
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findWithSearch(SearchData $searchData): iterable
    {
        $query = $this->createQueryBuilder('c');

        // Construire la requête en fonction des critères de recherche
         if ($searchData->getDateArrivee()) {
             $query->andWhere('c.dateArrivee >= :dateArrivee');
             $query->setParameter('dateArrivee', $searchData->getDateArrivee());
         }
         if ($searchData->getDateDepart()) {
             $query->andWhere('c.dateDepart <= :dateDepart');
             $query->setParameter('dateDepart', $searchData->getDateDepart());
        }
        if ($searchData->getCapaciteAdulte()) {
            $query->andWhere('c.capaciteAdulte >= :capaciteAdulte');
            $query->setParameter('capaciteAdulte', $searchData->getCapaciteAdulte());
        }
        if ($searchData->getCapaciteEnfant()) {
            $query->andWhere('c.capaciteEnfant >= :capaciteEnfant');
            $query->setParameter('capaciteEnfant', $searchData->getCapaciteEnfant());
        }


        // Exécuter la requête et retourner les résultats
        return $query->getQuery()->getResult();
    }

    
// calcul moyenne note des chambres
    public function findAverageRatingByChambreId(int $chambreId):?float
    {
        $qb = $this->createQueryBuilder('c')  
            ->leftJoin('c.commentaires', 'com') // Joignez les commentaires associés à la chambre via la relation 'commentaire'
            ->select('AVG(com.note)') // la fonction AVG() pour calculer la moyenne des notes des commentaires
            ->where('c.id = :chambreId') //  condition WHERE pour filtrer uniquement la chambre spécifiée
            ->setParameter('chambreId', $chambreId) // Définissez le paramètre pour l'ID de la chambre
            // Exécutez la requête et obtenez le résultat unique (la note moyenne)
            ->getQuery()
            ->getSingleScalarResult();
            
        // Vérifiez si le résultat n'est pas null (ce qui signifie qu'aucun commentaire n'a été trouvé)
        return $qb!== null? $qb : null;
    }
    
    
}