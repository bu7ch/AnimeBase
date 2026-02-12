<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\DuplicateEntryException;
use App\Exception\UserAlreadyReviewedException;
use App\Model\Genre;
use App\Model\Review;
use App\Model\Studio;

class Anime
{
    private int $id;
    private string $title;
    private string $description;
    private int $releaseYear;
    private int $episodes;
    private Studio $studio;
    /** @var Genre[] */
    private array $genres = [];
    /** @var Review[] */
    private array $reviews = [];

    public function __construct(
        int $id,
        string $title,
        string $description,
        int $releaseYear,
        int $episodes,
        Studio $studio
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->releaseYear = $releaseYear;
        $this->episodes = $episodes;
        $this->studio = $studio;
    }

    // Getters
    public function getId(): int { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function getDescription(): string { return $this->description; }
    public function getReleaseYear(): int { return $this->releaseYear; }
    public function getEpisodes(): int { return $this->episodes; }
    public function getStudio(): Studio { return $this->studio; }
    public function getGenres(): array { return $this->genres; }
    public function getReviews(): array { return $this->reviews; }

    // Setters
    public function setTitle(string $title): void { $this->title = $title; }
    public function setDescription(string $description): void { $this->description = $description; }
    public function setReleaseYear(int $year): void { $this->releaseYear = $year; }
    public function setEpisodes(int $episodes): void { $this->episodes = $episodes; }
    public function setStudio(Studio $studio): void { $this->studio = $studio; }

    /**
     * Ajoute un genre à l'animé (évite les doublons)
     */
    public function addGenre(Genre $genre): void
    {
        foreach ($this->genres as $existingGenre) {
            if ($existingGenre->getId() === $genre->getId()) {
                throw new DuplicateEntryException("Ce genre est déjà associé à l'animé.");
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

    /**
     * Ajoute un avis (vérifie qu'un utilisateur ne donne qu'un seul avis)
     */
    public function addReview(Review $review): void
    {
        foreach ($this->reviews as $existingReview) {
            if ($existingReview->getUser()->getId() === $review->getUser()->getId()) {
                throw new UserAlreadyReviewedException("Cet utilisateur a déjà noté cet animé.");
            }
        }
        $this->reviews[] = $review;
    }

    /**
     * Calcule la moyenne des notes
     */
    public function getAverageRating(): float
    {
        if (empty($this->reviews)) {
            return 0.0;
        }
        $sum = array_reduce($this->reviews, fn($carry, $review) => $carry + $review->getRating(), 0);
        return round($sum / count($this->reviews), 2);
    }

    public function __toString(): string
    {
        return sprintf(
            "%s (%d) - %d épisodes - Studio: %s - Note: %.1f/10",
            $this->title,
            $this->releaseYear,
            $this->episodes,
            $this->studio->getName(),
            $this->getAverageRating()
        );
    }
}