<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Customer
 *
 * @ORM\Table(name="customer")
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 */
class Customer implements UserInterface, EquatableInterface,  \Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var bool
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;

    /**
     * @var bool
     *
     * @ORM\Column(name="isEmailConfirmationPending", type="boolean")
     */
    private $isEmailConfirmationPending;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Company", mappedBy="customers")
     */
    private $companys;
    /**
     *
     * @return Collection|Company[]
     */
    public function getCompany(): Collection {
        return $this->companys;
    }

    /**
     *
     * @param Company $company
     * @return Customer
     */
    public function addCompany($company): self
    {
        if(!$this->companys->contains($company)){
            $this->companys[] = $company;
        }
        return $this;
    }

    /**
     * @param Company $company
     * @return Customer
     */
    public function removeCompany(Company $company): self {
        if($this->companys->contains($company)) {
            $this->companys->removeElement($company);
        }
        return $this;
    }



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set email
     *
     * @param string $email
     *
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Customer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Customer
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Customer
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set isEmailConfirmationPending
     *
     * @param boolean $isEmailConfirmationPending
     *
     * @return Customer
     */
    public function setIsEmailConfirmationPending($isEmailConfirmationPending)
    {
        $this->isEmailConfirmationPending = $isEmailConfirmationPending;

        return $this;
    }

    /**
     * Get isEmailConfirmationPending
     *
     * @return bool
     */
    public function getIsEmailConfirmationPending()
    {
        return $this->isEmailConfirmationPending;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof Customer) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }


        if ($this->email !== $user->getUsername()) {
            return false;
        }

        return true;
    }


    /**
     * String representation of object
     * @link https://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->email,
            $this->password,
        ]);
    }

    /**
     * Constructs the object
     * @link https://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list($this->id,$this->email,$this->password) =
            unserialize($serialized, ['allowed_classes' => false]);
    }
    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return ['ROLE_CUSTOMER'];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
       return $this->getEmail();
    }
}

