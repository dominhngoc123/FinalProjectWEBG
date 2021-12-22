<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AuthorRepository::class)
 */
class Author
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
    private $AuthorFullName;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $AuthorStageName;

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
     * @ORM\OneToMany(targetEntity=AuthorBook::class, mappedBy="Author")
     */
    private $authorBooks;

    public function __construct()
    {
        $this->authorBooks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthorFullName(): ?string
    {
        return $this->AuthorFullName;
    }

    public function setAuthorFullName(string $AuthorFullName): self
    {
        $this->AuthorFullName = $AuthorFullName;

        return $this;
    }

    public function getAuthorStageName(): ?string
    {
        return $this->AuthorStageName;
    }

    public function setAuthorStageName(?string $AuthorStageName): self
    {
        $this->AuthorStageName = $AuthorStageName;

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
     * @return Collection|AuthorBook[]
     */
    public function getAuthorBooks(): Collection
    {
        return $this->authorBooks;
    }

    public function addAuthorBook(AuthorBook $authorBook): self
    {
        if (!$this->authorBooks->contains($authorBook)) {
            $this->authorBooks[] = $authorBook;
            $authorBook->setAuthor($this);
        }

        return $this;
    }

    public function removeAuthorBook(AuthorBook $authorBook): self
    {
        if ($this->authorBooks->removeElement($authorBook)) {
            // set the owning side to null (unless already changed)
            if ($authorBook->getAuthor() === $this) {
                $authorBook->setAuthor(null);
            }
        }

        return $this;
    }
}
