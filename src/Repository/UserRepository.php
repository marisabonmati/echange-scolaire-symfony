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
        // delimiter avec un espace => Je vais à l'école => ["Je", "vais", "à", "l'école"]
        // delimiter avec ' => ["Je vais à l" , "école"]
        $explodedQ = explode(" ", $q);
        // SELECT * FROM game as g WHERE g.title LIKE '%et%' OR g.title LIKE '%totam%'
        $queryBuilder = $this->createQueryBuilder('u');// g est l'alias de notre table game


      /*  $i = 0;
        foreach ($explodedQ as $word) {
            $queryBuilder->orWhere('u.country LIKE :word' . $i);
            $queryBuilder->setParameter('word' . $i, '%' . $word . '%'); // :word0 = '%et%'
            $i++;
        }*/
        $i = 0;
        foreach (['firstname', 'adress', 'cp', 'city', 'country', 'language', 'level', 'lastName', 'options'] as $column){

            foreach ($explodedQ as $word) {
                $queryBuilder->orWhere('u.'.$column.' LIKE :word' .$i);
                $queryBuilder->setParameter('word'.$i, '%'.$word.'%'); // :word0 = '%et%'
                $i++;
            }
        }


        return $queryBuilder->getQuery()->getResult();

    }

/*  public function getLanguages()
    {
        return $languages = $this->createQueryBuilder('u')
        ->addSelect('u.language')
        ->groupby('language')
        ->getQuery();

    } */
    /*$query = $this->createQueryBuilder('q')
            ->select('userId, count(userId) as counter')
            ->groupby('userId')
            ->having('count(userId) >= 3')
            ->getQuery();

return $query->getResult();*/

    // /**
    //  * @return User[] Returns an array of User objects
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
    public function findOneBySomeField($value): ?User
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
