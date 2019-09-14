<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Company
 *
 * @ORM\Table(name="company")
 * @ORM\Entity(repositoryClass="App\Repository\CompanyRepository")
 */
class Company
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
     * @ORM\Column(name="companyName", type="string", length=255)
     */
    private $companyName;

    /**
     * @var string
     *
     * @ORM\Column(name="domain", type="string", length=255, nullable=false, unique=true)
     */
    private $domain;

    /**
     * @var int
     * @ORM\Column(name="is_active", type="boolean", nullable=false, options={"default" : 0})
     */
    private $isActive;

    /**
     * @ORM\Column(name="is_email_pending", type="boolean", nullable=false, options={"default" : 0})
     */
    private $isEmailConfirmationPending;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Customer", inversedBy="companys")
     * @ORM\JoinTable(name="companys_users")
     */
    private $customers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="Company", orphanRemoval=true)
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Category", mappedBy="Company", orphanRemoval=true)
     */
    private $categories;

    public function __construct() {
        $this->customers = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    /**
     *
     * @return Collection|Customer[]
     */
    public function getCustomers(): Collection {
        return $this->customers;
    }

    /**
    *
    * @param Customer $customer
     * @return Company
    */
    public function addCustomer($customer): self
    {
        if(!$this->customers->contains($customer)){
            $this->customers[] = $customer;
        }
        return $this;
    }

    /**
     * @param Customer $customer
     * @return Company
     */
    public function removeCustomer(Customer $customer): self {
        if($this->customers->contains($customer)) {
            $this->customers->removeElement($customer);
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
     * Set companyName
     *
     * @param string $companyName
     *
     * @return Company
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }
    /**
     * Get companyName
     *
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set domain
     *
     * @param string $domain
     *
     * @return Company
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }
    /**
     * Get domain
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
    /**
     * @param int $isActive
     * @return Company
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsEmailConfirmationPending()
    {
        return $this->isEmailConfirmationPending;
    }
    /**
     * @param boolean $isEmailConfirmationPending
     * @return Company
     */
    public function setIsEmailConfirmationPending($isEmailConfirmationPending)
    {
        $this->isEmailConfirmationPending = $isEmailConfirmationPending;
        return $this;
    }


    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCompany($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getCompany() === $this) {
                $user->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setCompany($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            // set the owning side to null (unless already changed)
            if ($category->getCompany() === $this) {
                $category->setCompany(null);
            }
        }

        return $this;
    }


}
