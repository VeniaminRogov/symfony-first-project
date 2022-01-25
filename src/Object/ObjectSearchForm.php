<?php

namespace App\Object;

use App\Entity\City;

class ObjectSearchForm {
    private $name;
    private $email;
    private $gender;
    private $city;
    private $phone;
    private int $page = 1;

    private $orderBy;
    private $sortField;

    public function getName() : ?string{
        return $this->name;
    }

    public function setName(string $name) : ?string{
        $this->name = $name;

        return $this->name;
    }

    public function getEmail() : ?string{
        return $this->email;
    }

    public function setEmail(string $email) : ?string{
        $this->email = $email;

        return $this->email;
    }

    public function getCity(): ?City{
        return $this->city;
    }

    public function setCity(City $city): ?City
    {
        $this->city = $city;

        return $this->city;
    }

    public function getOrderBy(): ?string{
        return $this->orderBy;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    public function setOrderBy(string $orderBy): ?string {
        $this->orderBy = $orderBy;

        return $this->orderBy;
    }

    public function getSortField(): ?string {
        return $this->sortField;
    }

    public function setSortField($sortField): ?string{
        $this->sortField = $sortField;

        return $this->sortField;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender): void
    {
        $this->gender = $gender;
    }

    public function getPage(): int{
        return $this->page;
    }


    public function setPage($page): int
    {
        return $this->page = $page;
    }
}