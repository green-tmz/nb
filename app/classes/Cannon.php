<?php

declare(strict_types=1);

namespace classes;

use interfaces\Shooter;
use interfaces\Transportable;

final class Cannon extends Unit implements Shooter, Transportable
{
    public function getType(): string
    {
        return 'Пушка';
    }

    public function canShoot(): bool
    {
        return true;
    }

    public function canMove(): bool
    {
        return false;
    }

    public function shoot(): bool
    {
        if ($this->destroyed) {
            return false;
        }

        return true;
    }

    public function moveByTransport(
        int $x,
        int $y,
        MineField $field,
        ?Unit $transporter = null
    ): bool
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
