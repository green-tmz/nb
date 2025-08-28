<?php

declare(strict_types=1);

namespace classes;

use interfaces\Movable;
use interfaces\Transport;
use interfaces\Transportable;

final class BTR extends Unit implements Movable, Transport
{
    private ?Unit $loadedUnit = null;

    public function getType(): string
    {
        return 'БТР';
    }

    public function canShoot(): bool
    {
        return false;
    }

    public function canMove(): bool
    {
        return true;
    }

    public function shoot(): bool
    {
        return false;
    }

    public function move(int $x, int $y, MineField $field): bool
    {
        if ($this->destroyed) {
            return false;
        }

        if ($field->hasMine($x, $y)) {
            $this->destroy();
            if (null !== $this->loadedUnit) {
                $this->loadedUnit->destroy();
            }

            return false;
        }

        $this->x = $x;
        $this->y = $y;

        if ($this->loadedUnit instanceof Transportable) {
            $this->loadedUnit->moveByTransport($x, $y, $field, $this);
        }

        return true;
    }

    public function load(Unit $unit): bool
    {
        if ($this->destroyed || null !== $this->loadedUnit) {
            return false;
        }

        if ($unit instanceof Soldier || $unit instanceof Cannon) {
            $this->loadedUnit = $unit;

            return true;
        }

        return false;
    }

    public function unload(): ?Unit
    {
        if (null === $this->loadedUnit) {
            return null;
        }

        $unit = $this->loadedUnit;
        $this->loadedUnit = null;

        return $unit;
    }

    public function getLoadedUnit(): ?Unit
    {
        return $this->loadedUnit;
    }

    public function hasLoadedUnit(): bool
    {
        return null !== $this->loadedUnit;
    }
}
