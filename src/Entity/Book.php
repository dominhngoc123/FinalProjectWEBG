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
     * @ORM\Column(type="string", length=255)
     */
    private $BookTitle;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $PublishedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $BookSummary;

    /**
     * @ORM\Column(type="float")
     */
    private $BookPrice;

    /**
     * @ORM\Column(type="smallint")
     */
    private $BookQuantity;

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
     * @ORM\OneToMany(targetEntity=OrderDetail::class, mappedBy="Book")
     */
    private $orderDetails;

    /**
     * @ORM\OneToMany(targetEntity=AuthorBook::class, mappedBy="Book")
     */
    private $authorBooks;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $BookImage;

    /**
     * @ORM\OneToMany(targetEntity=BookType::class, mappedBy="Book")
     */
    private $bookTypes;

    /**
     * @ORM\OneToMany(targetEntity=BookCategory::class, mappedBy="Book")
     */
    private $bookCategories;

    public function __construct()
    {
        $this->orderDetails = new ArrayCollection();
        $this->authorBooks = new ArrayCollection();
        $this->bookTypes = new ArrayCollection();
        $this->bookCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|OrderDetail[]
     */
    public function getOrderDetails(): Collection
    {
        return $this->orderDetails;
    }

    public function addOrderDetail(OrderDetail $orderDetail): self
    {
        if (!$this->orderDetails->contains($orderDetail)) {
            $this->orderDetails[] = $orderDetail;
            $orderDetail->setBook($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetail $orderDetail): self
    {
        if ($this->orderDetails->removeElement($orderDetail)) {
            // set the owning side to null (unless already changed)
            if ($orderDetail->getBook() === $this) {
                $orderDetail->setBook(null);
            }
        }

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
            $authorBook->setBook($this);
        }

        return $this;
    }

    public function removeAuthorBook(AuthorBook $authorBook): self
    {
        if ($this->authorBooks->removeElement($authorBook)) {
            // set the owning side to null (unless already changed)
            if ($authorBook->getBook() === $this) {
                $authorBook->setBook(null);
            }
        }

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

    /**
     * @return Collection|BookType[]
     */
    public function getBookTypes(): Collection
    {
        return $this->bookTypes;
    }

    public function addBookType(BookType $bookType): self
    {
        if (!$this->bookTypes->contains($bookType)) {
            $this->bookTypes[] = $bookType;
            $bookType->setBook($this);
        }

        return $this;
    }

    public function removeBookType(BookType $bookType): self
    {
        if ($this->bookTypes->removeElement($bookType)) {
            // set the owning side to null (unless already changed)
            if ($bookType->getBook() === $this) {
                $bookType->setBook(null);
            }
        }

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
            $bookCategory->setBook($this);
        }

        return $this;
    }

    public function removeBookCategory(BookCategory $bookCategory): self
    {
        if ($this->bookCategories->removeElement($bookCategory)) {
            // set the owning side to null (unless already changed)
            if ($bookCategory->getBook() === $this) {
                $bookCategory->setBook(null);
            }
        }

        return $this;
    }
}
