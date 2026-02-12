<?php

declare(strict_types=1);

namespace App\Model;

class Studio
{
    private int $id;
    private string $name;
    private string $country;
    private int $foundedYear;

    public function __construct(int $id, string $name, string $country, int $foundedYear)
    {
        $this->id = $id;
        $this->name = $name;
        $this->country = $country;
        $this->foundedYear = $foundedYear;
    }

    // Getters
    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getCountry(): string { return $this->country; }
    public function getFoundedYear(): int { return $this->foundedYear; }

    // Setters
    public function setName(string $name): void { $this->name = $name; }
    public function setCountry(string $country): void { $this->country = $country; }
    public function setFoundedYear(int $year): void { $this->foundedYear = $year; }

    public function __toString(): string
    {
        return $this->name . ' (' . $this->country . ', ' . $this->foundedYear . ')';
    }
}