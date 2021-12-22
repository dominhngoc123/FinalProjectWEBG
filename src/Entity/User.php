<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
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
    private $username;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $UserFullName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $UserAddress;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $UserPhoneNumber;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $UserDOB;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $UserEmail;

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
     * @ORM\Column(type="smallint")
     */
    private $Role;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="User")
     */
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getUserFullName(): ?string
    {
        return $this->UserFullName;
    }

    public function setUserFullName(?string $UserFullName): self
    {
        $this->UserFullName = $UserFullName;

        return $this;
    }

    public function getUserAddress(): ?string
    {
        return $this->UserAddress;
    }

    public function setUserAddress(?string $UserAddress): self
    {
        $this->UserAddress = $UserAddress;

        return $this;
    }

    public function getUserPhoneNumber(): ?string
    {
        return $this->UserPhoneNumber;
    }

    public function setUserPhoneNumber(?string $UserPhoneNumber): self
    {
        $this->UserPhoneNumber = $UserPhoneNumber;

        return $this;
    }

    public function getUserDOB(): ?\DateTimeInterface
    {
        return $this->UserDOB;
    }

    public function setUserDOB(?\DateTimeInterface $UserDOB): self
    {
        $this->UserDOB = $UserDOB;

        return $this;
    }

    public function getUserEmail(): ?string
    {
        return $this->UserEmail;
    }

    public function setUserEmail(?string $UserEmail): self
    {
        $this->UserEmail = $UserEmail;

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

    public function getRole(): ?int
    {
        return $this->Role;
    }

    public function setRole(int $Role): self
    {
        $this->Role = $Role;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setUser($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }

        return $this;
    }
}
