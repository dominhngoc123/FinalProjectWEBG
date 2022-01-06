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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AuthorImage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AuthorDescription;

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
     * @ORM\ManyToMany(targetEntity=Book::class, mappedBy="Author")
     */
    private $books;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AuthorGender;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $AuthorDOB;

    public function __construct()
    {
        $this->books = new ArrayCollection();
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

    public function getAuthorImage()
    {
        return $this->AuthorImage;
    }

    public function setAuthorImage($AuthorImage)
    {
        if ($AuthorImage != null)
        {
            $this->AuthorImage = $AuthorImage;
        }
        return $this;
    }

    public function getAuthorDescription(): ?string
    {
        return $this->AuthorDescription;
    }

    public function setAuthorDescription(?string $AuthorDescription): self
    {
        $this->AuthorDescription = $AuthorDescription;

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
     * @return Collection|Book[]
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
            $book->addAuthor($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->removeElement($book)) {
            $book->removeAuthor($this);
        }

        return $this;
    }

    public function getAuthorGender(): ?string
    {
        return $this->AuthorGender;
    }

    public function setAuthorGender(?string $AuthorGender): self
    {
        $this->AuthorGender = $AuthorGender;

        return $this;
    }

    public function getAuthorDOB(): ?\DateTimeInterface
    {
        return $this->AuthorDOB;
    }

    public function setAuthorDOB(?\DateTimeInterface $AuthorDOB): self
    {
        $this->AuthorDOB = $AuthorDOB;

        return $this;
    }
}
