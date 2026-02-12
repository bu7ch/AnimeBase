<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\InvalidRatingException;

class Review
{
    private int $id;
    private User $user;
    private Anime $anime;
    private int $rating;
    private ?string $comment;
    private \DateTime $createdAt;

    public function __construct(
        int $id,
        User $user,
        Anime $anime,
        int $rating,
        ?string $comment = null
    ) {
        if ($rating < 1 || $rating > 10) {
            throw new InvalidRatingException("La note doit être comprise entre 1 et 10.");
        }

        $this->id = $id;
        $this->user = $user;
        $this->anime = $anime;
        $this->rating = $rating;
        $this->comment = $comment;
        $this->createdAt = new \DateTime();
    }

    // Getters
    public function getId(): int { return $this->id; }
    public function getUser(): User { return $this->user; }
    public function getAnime(): Anime { return $this->anime; }
    public function getRating(): int { return $this->rating; }
    public function getComment(): ?string { return $this->comment; }
    public function getCreatedAt(): \DateTime { return $this->createdAt; }

    // Setters (limités car immutable après création)
    public function setRating(int $rating): void
    {
        if ($rating < 1 || $rating > 10) {
            throw new InvalidRatingException("La note doit être comprise entre 1 et 10.");
        }
        $this->rating = $rating;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }
}