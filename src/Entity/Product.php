<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    public function __construct(

        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private readonly int $id,

        #[ORM\Column(length: 255)]
        private string       $name,

        #[ORM\ManyToMany(targetEntity: customer::class, mappedBy: 'products')]
        private Collection   $customers,

        #[ORM\Column]
        private int          $stock = 0,

        #[ORM\Column(length: 255, nullable: true)]
        private ?string      $description = null,

        #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
        private ?string      $price = null,

        #[ORM\Column(length: 255, nullable: true)]
        private ?string      $imagePath = null,

    )
    {
        $this->customers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(?string $imagePath): static
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers->add($customer);
            $customer->addProducts($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): self
    {
        if ($this->customers->removeElement($customer)) {
            $customer->removeProduct($this);
        }

        return $this;
    }
}
