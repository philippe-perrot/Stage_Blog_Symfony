<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\ArticleSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    //Retourne les 3 derniers articles
    public function findLatest3(): array
    {
        return $this->findArticle()
            ->orderBy('article.date', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    //Retourne les 5 derniers articles
    public function findLatest5(): array
    {
        return $this->findArticle()
            ->orderBy('article.date', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    //Retourne les 3 articles aléatoires
    public function articleRandom(): array
    {
        $count = $this->findArticle()
            ->select('COUNT(article.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $numbers = range(1, $count);
        shuffle($numbers);
        $numbers = array_slice($numbers, 0, 5);

        return $this->findArticle()
            ->where('article.id IN (:ids)')
            ->setParameter('ids', $numbers)
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    public function findAllArticleQuery(ArticleSearch $search): Query
    {
        $query = $this->findArticle()
            ->orderBy('article.date', 'DESC');

        if($search->getArticle()) {
            $query = $query
                ->andwhere('article.titre LIKE :titre')
                ->setParameter('titre', '%'.$search->getArticle().'%');
        }

        if($search->getCategory()->count() > 0) {
            $query = $query
                ->andWhere('article.category IN (:category)')
                ->setParameter('category', $search->getCategory());
        }

        if($search->getDate()) {
            $query = $query
                ->andwhere('article.date = :date')
                ->setParameter('date', $search->getDate());
        }
        return $query ->getQuery();
    }

    //Retourne les articles
    private function findArticle(): QueryBuilder
    {
        return $this->createQueryBuilder('article');
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
