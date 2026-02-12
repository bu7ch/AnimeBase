<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\DuplicateEntryException;
// Similaire à FavoriteList, peut être une classe générique, mais ici simple copie
class Watchlist
{
    /** @var Anime[] */
    private array $items = [];

    public function getAll(): array
    {
        return array_values($this->items);
    }

    public function add(Anime $anime): void
    {
        $id = $anime->getId();
        if (isset($this->items[$id])) {
            throw new DuplicateEntryException("Cet animé est déjà dans la watchlist.");
        }
        $this->items[$id] = $anime;
    }
    public function remove(Anime $anime): void
    {
        $id = $anime->getId();
        if (isset($this->items[$id])) {
            unset($this->items[$id]);
        }
    }

    public function contains(Anime $anime): bool
    {
        return isset($this->items[$anime->getId()]);
    }

    public function count(): int
    {
        return count($this->items);
    }
}