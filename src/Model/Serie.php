<?php

declare(strict_types=1);


class Series extends Anime
{
    private int $season;

    public function __construct(
        int $id,
        string $title,
        string $description,
        int $releaseYear,
        int $episodes,
        int $season
    ) {
        parent::__construct($id, $title, $description, $releaseYear, $episodes);
        $this->season = $season;
    }

    public function getSeason(): int { return $this->season; }
    public function setSeason(int $season): void { $this->season = $season; }

    public function __toString(): string
    {
        return parent::__toString() . " (Saison {$this->season})";
    }
}