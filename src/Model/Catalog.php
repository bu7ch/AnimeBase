<?php

declare(strict_types=1);

namespace App\Catalog;

use App\Model\Anime;
use App\Model\Genre;
use App\Model\Studio;
use App\Exception\AnimeNotFoundException;

class Catalog
{
    /** @var Anime[] indexed by id */
    private array $animes = [];

    /**
     * Ajoute un animé au catalogue (évite les doublons par id)
     */
    public function addAnime(Anime $anime): void
    {
        $id = $anime->getId();
        if (isset($this->animes[$id])) {
            throw new \App\Exception\DuplicateEntryException("Un animé avec cet ID existe déjà.");
        }
        $this->animes[$id] = $anime;
    }

    public function removeAnime(Anime $anime): void
    {
        $id = $anime->getId();
        if (isset($this->animes[$id])) {
            unset($this->animes[$id]);
        }
    }

    public function getAnimeById(int $id): Anime
    {
        if (!isset($this->animes[$id])) {
            throw new AnimeNotFoundException("Aucun animé trouvé avec l'ID $id.");
        }
        return $this->animes[$id];
    }

    /**
     * @return Anime[]
     */
    public function getAllAnimes(): array
    {
        return array_values($this->animes);
    }

    /**
     * Recherche par titre (insensible à la casse, contient)
     * @return Anime[]
     */
    public function searchByTitle(string $title): array
    {
        $title = strtolower($title);
        return array_filter(
            $this->animes,
            fn(Anime $a) => str_contains(strtolower($a->getTitle()), $title)
        );
    }

    /**
     * @return Anime[]
     */
    public function searchByGenre(Genre $genre): array
    {
        return array_filter(
            $this->animes,
            function (Anime $a) use ($genre) {
                foreach ($a->getGenres() as $g) {
                    if ($g->getId() === $genre->getId()) {
                        return true;
                    }
                }
                return false;
            }
        );
    }

    /**
     * @return Anime[]
     */
    public function searchByStudio(Studio $studio): array
    {
        return array_filter(
            $this->animes,
            fn(Anime $a) => $a->getStudio()->getId() === $studio->getId()
        );
    }

    /**
     * @return Anime[]
     */
    public function searchByYearRange(int $start, int $end): array
    {
        return array_filter(
            $this->animes,
            fn(Anime $a) => $a->getReleaseYear() >= $start && $a->getReleaseYear() <= $end
        );
    }

    /**
     * @return Anime[]
     */
    public function searchByRating(float $minRating): array
    {
        return array_filter(
            $this->animes,
            fn(Anime $a) => $a->getAverageRating() >= $minRating
        );
    }
}