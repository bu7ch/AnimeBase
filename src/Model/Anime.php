<?php

declare(strict_types=1);


class Anime
{
    private int $id;
    private string $title;
    private string $description;
    private int $releaseYear;
    private int $episodes;
    /** @var Genre[] */
    private array $genres = [];

    public function __construct(
        int $id,
        string $title,
        string $description,
        int $releaseYear,
        int $episodes,
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->releaseYear = $releaseYear;
        $this->episodes = $episodes;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getReleaseYear(): int
    {
        return $this->releaseYear;
    }
    public function getEpisodes(): int
    {
        return $this->episodes;
    }
    public function getGenres(): array
    {
        return $this->genres;
    }



    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
    public function setReleaseYear(int $year): void
    {
        $this->releaseYear = $year;
    }
    public function setEpisodes(int $episodes): void
    {
        $this->episodes = $episodes;
    }


    /**
     * Ajoute un genre à l'animé (évite les doublons)
     */
    public function addGenre(Genre $genre): void
    {
        foreach ($this->genres as $existingGenre) {
            if ($existingGenre->getId() === $genre->getId()) {
                throw new InvalidArgumentException("Ce genre est déjà associé à l'animé.");
            }
        }
        $this->genres[] = $genre;
    }

    public function removeGenre(Genre $genre): void
    {
        foreach ($this->genres as $key => $existingGenre) {
            if ($existingGenre->getId() === $genre->getId()) {
                unset($this->genres[$key]);
                $this->genres = array_values($this->genres);
                return;
            }
        }
    }

    /**
     * Retourne la liste des noms de genres sous forme de chaîne
     */
    public function getGenresList(): string
    {
        $names = array_map(fn(Genre $g) => $g->getName(), $this->genres);
        return implode(', ', $names);
    }

    public function __toString(): string
    {
        return sprintf(
            "%s (%d) - %d épisodes",
            $this->title,
            $this->releaseYear,
            $this->episodes
        );
    }
}
