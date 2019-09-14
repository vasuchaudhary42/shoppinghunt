<?php


namespace App\Services;


use App\Entity\User;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;

class TokenGenerator
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function generateToken(int $length = 32): ?string
    {
        while (1){
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $token = '';
            for ($i = 0; $i < $length; $i++) {
                $token .= $characters[rand(0, $charactersLength - 1)];
            }
            if (!$this->entityManager->createQueryBuilder()
                ->select('count(u.token)')->from(User::class,'u')
                ->where('u.token = :token')
                ->setParameter(':token',$token)
                ->getQuery()
                ->getSingleScalarResult()){
                return $token;
            }

        }
        return rtrim(strtr(base64_encode(random_bytes($length)), '+/', '-_'), '=');
    }
}