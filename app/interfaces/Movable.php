<?php

declare(strict_types=1);

namespace interfaces;

use classes\MineField;

interface Movable
{
    public function move(int $x, int $y, MineField $field): bool;
}
