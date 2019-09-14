<?php


namespace App\Provider;


use App\Entity\Company;
use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class CustomerProvider implements UserProviderInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $username The username
     * @return Customer|object
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($username)
    {
        return $this->em->getRepository(Customer::class)->findOneBy(['email' => $username]);
    }

    /**
     * @param UserInterface $user
     * @return Customer|object
     */
    public function refreshUser(UserInterface $user)
    {
        if(in_array('ROLE_CUSTOMER', $user->getRoles())) {
            return $this->em->getRepository(Customer::class)->findOneBy(['email' => $user->getEmail()]);
        }
        throw new UsernameNotFoundException('User Not Found');
    }

    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return Customer::class === $class;
    }
}
