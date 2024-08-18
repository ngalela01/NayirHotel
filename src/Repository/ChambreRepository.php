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


    public function findWithSearch(SearchData $searchData): iterable
{
    $query = $this->createQueryBuilder('c')
        ->leftJoin('c.reservations', 'r')
        ->addSelect('r');

    // Formatage des dates en 'Y-m-d' pour MySQL
    if ($searchData->getDateArrivee() && $searchData->getDateDepart()) {
        $dateArrivee = \DateTime::createFromFormat('d-m-Y', $searchData->getDateArrivee());
        $dateDepart = \DateTime::createFromFormat('d-m-Y', $searchData->getDateDepart());

        if ($dateArrivee && $dateDepart) {
            $query->andWhere('r.dateArrive IS NULL OR r.dateDepart IS NULL OR (r.dateDepart < :dateArrivee OR r.dateArrive > :dateDepart)')
                ->setParameter('dateArrivee', $dateArrivee->format('Y-m-d'))
                ->setParameter('dateDepart', $dateDepart->format('Y-m-d'));
        }
    }

    if ($searchData->getCapaciteAdulte()) {
        $query->andWhere('c.capaciteAdulte >= :capaciteAdulte')
            ->setParameter('capaciteAdulte', $searchData->getCapaciteAdulte());
    }

    if ($searchData->getCapaciteEnfant()) {
        $query->andWhere('c.capaciteEnfant >= :capaciteEnfant')
            ->setParameter('capaciteEnfant', $searchData->getCapaciteEnfant());
    }

    return $query->getQuery()->getResult();
}

    
// calcul moyenne note des chambres
    public function findAverageRatingByChambreId(int $chambreId):?float
    {
        $qb = $this->createQueryBuilder('c')  
            ->leftJoin('c.commentaires', 'com') // Joignez les commentaires associés à la chambre via la relation 'commentaire'
            ->select('AVG(com.note)') // la fonction AVG() pour calculer la moyenne des notes
            ->where('c.id = :chambreId') //  condition WHERE pour filtrer uniquement la chambre spécifiée
            ->setParameter('chambreId', $chambreId) // Définissez le paramètre pour l'ID de la chambre
            // Exécutez la requête et obtenez le résultat unique (la note moyenne)
            ->getQuery()
            ->getSingleScalarResult();
            
        // Vérifiez si le résultat n'est pas null (ce qui signifie qu'aucun commentaire n'a été trouvé)
        return $qb!== null? $qb : null;
    }
    
    
}