<?php

declare(strict_types=1);


class Movie extends Anime
{
    private int $duration; // en minutes

    public function __construct(
        int $id,
        string $title,
        string $description,
        int $releaseYear,
        int $duration
    ) {
        // Un film n'a pas d'épisodes, on passe 0 ou null
        parent::__construct($id, $title, $description, $releaseYear, 0);
        $this->duration = $duration;
    }

    public function getDuration(): int { return $this->duration; }
    public function setDuration(int $duration): void { $this->duration = $duration; }

    /**
     * Surcharge pour retourner 0 épisode (logique métier)
     */
    public function getEpisodes(): int
    {
        return 0;
    }

    public function __toString(): string
    {
        return sprintf(
            "%s (%d) - %d min",
            $this->getTitle(),
            $this->getReleaseYear(),
            $this->duration
        );
    }
}