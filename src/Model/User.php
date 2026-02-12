<?php

declare(strict_types=1);

namespace App\Model;

class User
{
    private int $id;
    private string $username;
    private string $email;
    private string $password; 
    private \DateTime $registrationDate;
    private FavoriteList $favoriteList;
    private Watchlist $watchlist;

    public function __construct(int $id, string $username, string $email, string $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->registrationDate = new \DateTime();
        $this->favoriteList = new FavoriteList();
        $this->watchlist = new Watchlist();
    }

    // Getters
    public function getId(): int { return $this->id; }
    public function getUsername(): string { return $this->username; }
    public function getEmail(): string { return $this->email; }
    public function getRegistrationDate(): \DateTime { return $this->registrationDate; }
    public function getFavoriteList(): FavoriteList { return $this->favoriteList; }
    public function getWatchlist(): Watchlist { return $this->watchlist; }

    // Setters
    public function setUsername(string $username): void { $this->username = $username; }
    public function setEmail(string $email): void { $this->email = $email; }
    public function setPassword(string $password): void { $this->password = $password; }

    /**
     * Vérification simple du mot de passe
     */
    public function verifyPassword(string $password): bool
    {
        return $this->password === $password;
    }

    public function addFavorite(Anime $anime): void
    {
        $this->favoriteList->add($anime);
    }

    public function removeFavorite(Anime $anime): void
    {
        $this->favoriteList->remove($anime);
    }

    public function addToWatchlist(Anime $anime): void
    {
        $this->watchlist->add($anime);
    }

    public function removeFromWatchlist(Anime $anime): void
    {
        $this->watchlist->remove($anime);
    }
}