<?php

namespace App\Entity;

use App\Repository\AuthorBookRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AuthorBookRepository::class)
 */
class AuthorBook
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="authorBooks")
     */
    private $Author;

    /**
     * @ORM\ManyToOne(targetEntity=Book::class, inversedBy="authorBooks")
     */
    private $Book;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?Author
    {
        return $this->Author;
    }

    public function setAuthor(?Author $Author): self
    {
        $this->Author = $Author;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->Book;
    }

    public function setBook(?Book $Book): self
    {
        $this->Book = $Book;

        return $this;
    }
}
