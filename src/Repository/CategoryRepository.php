<?php

namespace App\Repository;

use App\Entity\Category;
use App\Services\CoreService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    /**
     * @var CoreService
     */
    private $coreService;
    /**
     * @var Request
     */
    private $request;

    /**
     * CategoryRepository constructor.
     * @param RegistryInterface $registry
     * @param CoreService $coreService
     * @param RequestStack $request
     */
    public function __construct(RegistryInterface $registry, CoreService $coreService, RequestStack $request)
    {
        parent::__construct($registry, Category::class);
        $this->coreService = $coreService;
        $this->request = $request->getMasterRequest();
    }

    function getCategory($params = []){
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('c')->from($this->getEntityName(),'c')
            ->andWhere('c.Company = :company')
            ->setParameter(':company',$this->coreService->getCompany()->getId());

        foreach ($params as $property => $param){
            $qb->andWhere("c.$property =:$property")
                ->setParameter(":$property", $param);
        }
        return $qb->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);
    }

    public function deleteCategory($id){
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->delete($this->getEntityName(),'c')
            ->andwhere('c.Company = :Company')
            ->andwhere("c.id = :id")
            ->setParameter(":Company",$this->coreService->getCompany()->getId())
            ->setParameter(':id',$id)
            ->getQuery();
        return $qb->execute();
    }
}
