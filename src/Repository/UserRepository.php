<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function searchNav($q)
    {
        $explodedQ = explode(" ", $q);
        $queryBuilder = $this->createQueryBuilder('u');

        $i = 0;
        foreach (['firstname', 'adress', 'cp', 'city', 'country', 'language', 'level', 'lastName', 'options'] as $column) {

            foreach ($explodedQ as $word) {
                $queryBuilder->orWhere('u.' . $column . ' LIKE :word' . $i);
                $queryBuilder->setParameter('word' . $i, '%' . $word . '%');
                $i++;
            }
        }
        return $queryBuilder->getQuery()->getResult();
    }

    public function getLanguages()
    {   // ICI, NOUS RECUPERONS EN DYNAMIQUE, LA LISTE DE TOUS LES LANGAGES
        return $languages = $this->createQueryBuilder('u')
            ->select('u.language')
            ->where('u.language IS NOT NULL')
            ->groupBy('u.language')
            ->getQuery()
            ->getArrayResult();
    }

    public function getCountry()
    {   // ICI, NOUS RECUPERONS EN DYNAMIQUE, LA LISTE DE TOUS LES PAYS
        return $country = $this->createQueryBuilder('u')
            ->select('u.country')
            ->where('u.country IS NOT NULL')
            ->groupBy('u.country')
            ->getQuery()
            ->getArrayResult();
    }

    public function searchSelect($language, $options, $entite)
    {   // REQUETE POUR LE FORMULAIRE DE RECHERCHE 'SELECT' SUR LA PAGE INDEX
        return $this->createQueryBuilder('u')
            ->where('u.language LIKE :language')
            ->andWhere('u.options = :options')
            ->andWhere('u.entite = :entite')
            ->setParameter('language', '%'.$language.'%')
            ->setParameter('options', $options)
            ->setParameter('entite', $entite)
            ->getQuery()
            ->getResult();
    }

    public function AffinerRechercheSelect($language, $options, $level, $country, $capacity)
    {   // REQUETE POUR LE FORMULAIRE DE LA RECHERCHE AVANCEE SUR LA PAGE SEARCH

        $queryBuilder = $this->createQueryBuilder('u')
            ->where('u.language LIKE :language')
            ->andWhere('u.options IN (:options)')
            // ->andWhere('u.level IN (:level)') // u.level = [ "english","french"] et ("french","english")
                // lycee LIKE %u.level
                // OR college LIKE %u.level
            ->andWhere('u.country = :country')
            ->setParameter('language', '%'.$language.'%')
            ->setParameter('options', $options)
            // ->setParameter('level', $level)
            ->setParameter('country', $country);
        $or = $queryBuilder->expr()->orX();
        $i = 0;
        foreach ($level as $l) {
            $or->add('u.level LIKE :level'.$i);
            $queryBuilder->setParameter('level'.$i, '%'.$l.'%');
        }
        $queryBuilder->andWhere($or);
        switch ($capacity) {
            case '<30':
                $queryBuilder->andWhere('u.capacity < :capacity')
                    ->setParameter('capacity', 30);
                break;
            case '>40':
                $queryBuilder->andWhere('u.capacity > :capacity')
                    ->setParameter('capacity', 40);
                break;
            case 'entre 30 et 40':
                $queryBuilder
                    ->andWhere('u.capacity < :capacity1')
                    ->setParameter('capacity1', 40)
                    ->andWhere('u.capacity > :capacity2')
                    ->setParameter('capacity2', 30);

                break;
        }
        return $queryBuilder->getQuery()->getResult();
    }

    public function actualites()
    {   // REQUETE ALEATOIRE POUR AFFICHER DEUX PROFILS D'UTILISATEURS
        return $this->createQueryBuilder('u')
            ->setMaxResults(2)
            ->orderBy('RAND()')
            ->getQuery()
            ->getResult();
    }

}
