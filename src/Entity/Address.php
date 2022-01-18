<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $str1;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $str2;

    #[ORM\Column(type: 'integer')]
    private $zip;

    #[ORM\ManyToOne(targetEntity: City::class, inversedBy: 'addresses')]
    private $city;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStr1(): ?string
    {
        return $this->str1;
    }

    public function setStr1(string $str1): self
    {
        $this->str1 = $str1;

        return $this;
    }

    public function getStr2(): ?string
    {
        return $this->str2;
    }

    public function setStr2(?string $str2): self
    {
        $this->str2 = $str2;

        return $this;
    }

    public function getZip(): ?int
    {
        return $this->zip;
    }

    public function setZip(int $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }
}
