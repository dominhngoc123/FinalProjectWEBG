<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Author::class, inversedBy="books")
     */
    private $Author;

    /**
     * @ORM\ManyToMany(targetEntity=Type::class, inversedBy="books")
     */
    private $Type;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="books")
     */
    private $Category;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $BookTitle;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $PublishedAt;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $PublishedBy;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $BookSummary;

    /**
     * @ORM\Column(type="float")
     */
    private $BookPrice;

    /**
     * @ORM\Column(type="integer")
     */
    private $BookQuantity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $BookImage;

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
     * @ORM\ManyToMany(targetEntity=Order::class, inversedBy="books")
     */
    private $_Order;

    public function __construct()
    {
        $this->Author = new ArrayCollection();
        $this->Type = new ArrayCollection();
        $this->Category = new ArrayCollection();
        $this->_Order = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Author[]
     */
    public function getAuthor(): Collection
    {
        return $this->Author;
    }

    public function addAuthor(Author $author): self
    {
        if (!$this->Author->contains($author)) {
            $this->Author[] = $author;
        }

        return $this;
    }

    public function removeAuthor(Author $author): self
    {
        $this->Author->removeElement($author);

        return $this;
    }

    /**
     * @return Collection|Type[]
     */
    public function getType(): Collection
    {
        return $this->Type;
    }

    public function addType(Type $type): self
    {
        if (!$this->Type->contains($type)) {
            $this->Type[] = $type;
        }

        return $this;
    }

    public function removeType(Type $type): self
    {
        $this->Type->removeElement($type);

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategory(): Collection
    {
        return $this->Category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->Category->contains($category)) {
            $this->Category[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->Category->removeElement($category);

        return $this;
    }

    public function getBookTitle(): ?string
    {
        return $this->BookTitle;
    }

    public function setBookTitle(string $BookTitle): self
    {
        $this->BookTitle = $BookTitle;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->PublishedAt;
    }

    public function setPublishedAt(?\DateTimeInterface $PublishedAt): self
    {
        $this->PublishedAt = $PublishedAt;

        return $this;
    }

    public function getPublishedBy(): ?string
    {
        return $this->PublishedBy;
    }

    public function setPublishedBy(?string $PublishedBy): self
    {
        $this->PublishedBy = $PublishedBy;

        return $this;
    }

    public function getBookSummary(): ?string
    {
        return $this->BookSummary;
    }

    public function setBookSummary(?string $BookSummary): self
    {
        $this->BookSummary = $BookSummary;

        return $this;
    }

    public function getBookPrice(): ?float
    {
        return $this->BookPrice;
    }

    public function setBookPrice(float $BookPrice): self
    {
        $this->BookPrice = $BookPrice;

        return $this;
    }

    public function getBookQuantity(): ?int
    {
        return $this->BookQuantity;
    }

    public function setBookQuantity(int $BookQuantity): self
    {
        $this->BookQuantity = $BookQuantity;

        return $this;
    }

    public function getBookImage(): ?string
    {
        return $this->BookImage;
    }

    public function setBookImage(?string $BookImage): self
    {
        $this->BookImage = $BookImage;

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
     * @return Collection|Order[]
     */
    public function getOrder(): Collection
    {
        return $this->_Order;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->_Order->contains($order)) {
            $this->_Order[] = $order;
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        $this->_Order->removeElement($order);

        return $this;
    }
}
