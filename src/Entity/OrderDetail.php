<?php

namespace App\Entity;

use App\Repository\OrderDetailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderDetailRepository::class)
 */
class OrderDetail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $CurrentPrice;

    /**
     * @ORM\Column(type="smallint")
     */
    private $Quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Book::class, inversedBy="OrderDetail")
     */
    private $book;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="OrderDetail")
     */
    private $_order;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrentPrice(): ?float
    {
        return $this->CurrentPrice;
    }

    public function setCurrentPrice(float $CurrentPrice): self
    {
        $this->CurrentPrice = $CurrentPrice;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->Quantity;
    }

    public function setQuantity(int $Quantity): self
    {
        $this->Quantity = $Quantity;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->_order;
    }

    public function setOrder(?Order $_order): self
    {
        $this->_order = $_order;

        return $this;
    }
}
