<?php

declare(strict_types=1);

namespace classes;

abstract class Unit
{
    protected bool $destroyed;

    public function __construct(
        protected int $x,
        protected int $y,
    ) {
        $this->destroyed = false;
    }

    /**
     * @return array{x: int, y: int}
     */
    public function getPosition(): array
    {
        return ['x' => $this->x, 'y' => $this->y];
    }

    public function isDestroyed(): bool
    {
        return $this->destroyed;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function destroy(): void
    {
        $this->destroyed = true;
    }

    abstract public function getType(): string;

    abstract public function canShoot(): bool;

    abstract public function canMove(): bool;
}
