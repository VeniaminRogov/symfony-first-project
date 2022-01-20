<?php

namespace App\Object;

use phpDocumentor\Reflection\Types\This;

class ObjectSearchForm {
    private $name;
    private $email;
    private $gender;
    private $city;

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

    public function getCity() : ?string{
        return $this->city;
    }

    public function setCity(string $city) : ?string{
        $this->city = $city;

        return $this->city;
    }


    public function getOrderBy(): ?string{
        return $this->orderBy;
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
}