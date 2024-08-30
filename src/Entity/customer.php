<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


//TODO: add the repository
#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class customer
{
    public function __construct(

        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private int $id,

        #[ORM\Column(length: 255)]
        private string       $name,

        #[ORM\Column(length: 255)]
        private string       $email,

        #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'customers')]
        private Collection   $products = new ArrayCollection(),

        #[ORM\Column(length: 255, nullable: true)]
        private ?string      $address = null,

        #[ORM\Column(length: 255, nullable: true)]
        private ?string      $phone = null,

    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProducts(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->addCustomer($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removeCustomer($this);
        }

        return $this;
    }
}