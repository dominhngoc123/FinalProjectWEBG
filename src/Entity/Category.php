<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $CategoryName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CategoryDescription;

    /**
     * @ORM\Column(type="datetime")
     */
    private $CreateAt;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $CreateBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $UpdateAt;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $UpdateBy;

    /**
     * @ORM\OneToMany(targetEntity=BookCategory::class, mappedBy="Category")
     */
    private $bookCategories;

    public function __construct()
    {
        $this->bookCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryName(): ?string
    {
        return $this->CategoryName;
    }

    public function setCategoryName(string $CategoryName): self
    {
        $this->CategoryName = $CategoryName;

        return $this;
    }

    public function getCategoryDescription(): ?string
    {
        return $this->CategoryDescription;
    }

    public function setCategoryDescription(?string $CategoryDescription): self
    {
        $this->CategoryDescription = $CategoryDescription;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->CreateAt;
    }

    public function setCreateAt(\DateTimeInterface $CreateAt): self
    {
        $this->CreateAt = $CreateAt;

        return $this;
    }

    public function getCreateBy(): ?string
    {
        return $this->CreateBy;
    }

    public function setCreateBy(string $CreateBy): self
    {
        $this->CreateBy = $CreateBy;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->UpdateAt;
    }

    public function setUpdateAt(?\DateTimeInterface $UpdateAt): self
    {
        $this->UpdateAt = $UpdateAt;

        return $this;
    }

    public function getUpdateBy(): ?string
    {
        return $this->UpdateBy;
    }

    public function setUpdateBy(?string $UpdateBy): self
    {
        $this->UpdateBy = $UpdateBy;

        return $this;
    }

    /**
     * @return Collection|BookCategory[]
     */
    public function getBookCategories(): Collection
    {
        return $this->bookCategories;
    }

    public function addBookCategory(BookCategory $bookCategory): self
    {
        if (!$this->bookCategories->contains($bookCategory)) {
            $this->bookCategories[] = $bookCategory;
            $bookCategory->setCategory($this);
        }

        return $this;
    }

    public function removeBookCategory(BookCategory $bookCategory): self
    {
        if ($this->bookCategories->removeElement($bookCategory)) {
            // set the owning side to null (unless already changed)
            if ($bookCategory->getCategory() === $this) {
                $bookCategory->setCategory(null);
            }
        }

        return $this;
    }
}
