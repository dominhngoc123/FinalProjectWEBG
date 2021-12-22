<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeRepository::class)
 */
class Type
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
    private $TypeName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $TypeDescription;

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
     * @ORM\OneToMany(targetEntity=BookType::class, mappedBy="Type")
     */
    private $bookTypes;

    public function __construct()
    {
        $this->bookTypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeName(): ?string
    {
        return $this->TypeName;
    }

    public function setTypeName(string $TypeName): self
    {
        $this->TypeName = $TypeName;

        return $this;
    }

    public function getTypeDescription(): ?string
    {
        return $this->TypeDescription;
    }

    public function setTypeDescription(?string $TypeDescription): self
    {
        $this->TypeDescription = $TypeDescription;

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
            $bookType->setType($this);
        }

        return $this;
    }

    public function removeBookType(BookType $bookType): self
    {
        if ($this->bookTypes->removeElement($bookType)) {
            // set the owning side to null (unless already changed)
            if ($bookType->getType() === $this) {
                $bookType->setType(null);
            }
        }

        return $this;
    }
}
