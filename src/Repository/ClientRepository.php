<?php

namespace App\Repository;

use App\Entity\Client;
use App\Object\ObjectSearchForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function countClients(){
        return $this->createQueryBuilder('c')
                        ->select('count(c.id)')
                        ->getQuery()
                        ->getSingleScalarResult();
    }

    public function sort(ObjectSearchForm $data){
        if(!$data) {
            return $this->findAll();
        }
        $req = $this->createQueryBuilder('c');
        $req
            ->leftJoin('c.address', 'ca')
            ->leftJoin('ca.city', 'ci');

        if($data->getName()){
            $req
            ->andWhere('
                        (c.firstName LIKE :name) OR
                        (c.lastName LIKE :name)
                    ')
            ->setParameter('name', "%".$data->getName()."%");
        }

        if($data->getEmail()){
            $req
                ->andWhere("c.email = :email")
                ->setParameter('email', $data->getEmail());
        }


        if($data->getGender()){
            $req
                ->andWhere('c.gender = :gender')
                ->setParameter('gender', $data->getGender());
        }

        if($data->getCity()){
            $req
                ->andWhere('ci.id = :cityName')
                ->setParameter('cityName', $data->getCity());
        }

        if($data->getSortField() && $data->getOrderBy()){
            $req
                ->orderBy($data->getSortField(), $data->getOrderBy());
        }


        return $req->getQuery()->getResult();
    }



    // /**
    //  * @return Client[] Returns an array of Client objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Client
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
