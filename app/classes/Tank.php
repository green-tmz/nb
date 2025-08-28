<?php

declare(strict_types=1);

namespace classes;

use interfaces\Movable;
use interfaces\Shooter;

final class Tank extends Unit implements Movable, Shooter
{
    public function getType(): string
    {
        return 'Танк';
    }

    public function canShoot(): bool
    {
        return true;
    }

    public function canMove(): bool
    {
        return true;
    }

    public function shoot(): bool
    {
        if ($this->destroyed) {
            return false;
        }

        return true;
    }

    public function move(int $x, int $y, MineField $field): bool
    {
        if ($this->destroyed) {
            return false;
        }

        if ($field->hasMine($x, $y)) {
            $this->destroy();

            return false;
        }

        $this->x = $x;
        $this->y = $y;

        return true;
    }
}
