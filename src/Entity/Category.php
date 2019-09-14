<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="categories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Company;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="categories")
     */
    private $User;



    /**
     * @ORM\Column(type="boolean")
     */
    private $root;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="categories")
     */
    private $Category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Category", mappedBy="Category")
     */
    private $categories;

    public function __construct()
    {
        $this->User = new ArrayCollection();
        $this->subCategory = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->Company;
    }

    public function setCompany(?Company $Company): self
    {
        $this->Company = $Company;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->User;
    }

    public function addUser(User $user): self
    {
        if (!$this->User->contains($user)) {
            $this->User[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->User->contains($user)) {
            $this->User->removeElement($user);
        }

        return $this;
    }


    public function getRoot(): ?bool
    {
        return $this->root;
    }

    public function setRoot(bool $root): self
    {
        $this->root = $root;

        return $this;
    }

    public function getCategory(): ?self
    {
        return $this->Category;
    }

    public function setCategory(?self $Category): self
    {
        $this->Category = $Category;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(self $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setCategory($this);
        }

        return $this;
    }

    public function removeCategory(self $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            // set the owning side to null (unless already changed)
            if ($category->getCategory() === $this) {
                $category->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @param string $property
     * @param $value
     * @return Category
     */
    public function updateProperty(string $property, $value): self
    {
        $this->{$property} = $value;
        return $this;
    }
}
