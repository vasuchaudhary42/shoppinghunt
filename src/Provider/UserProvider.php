<?php


namespace App\Provider;


use App\Entity\Company;
use App\Entity\User;
use App\Services\CompanyService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var CompanyService
     */
    private $companyService;

    public function __construct(EntityManagerInterface $em,CompanyService $companyService)
    {
        $this->em = $em;
        $this->companyService = $companyService;
    }

    /**
     * @param UserInterface $username The username
     * @return UserInterface
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($username)
    {
        $company = $this->companyService->getCompany();
        return $this->em->getRepository(User::class)->findOneBy(['email' => $username, 'Company' => $company->getId()]);
    }

    /**
     * @param UserInterface $user
     * @return User|object
     */
    public function refreshUser(UserInterface $user)
    {
        if(in_array('ROLE_COMPANY', $user->getRoles())) {
            return $this->em->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);
        }
        throw new UsernameNotFoundException('User Not Found');
    }

    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return User::class === $class;
    }
}
