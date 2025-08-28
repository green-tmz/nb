<?php

declare(strict_types=1);

namespace interfaces;

use classes\MineField;
use classes\Unit;

interface Transportable
{
    public function moveByTransport(
        int $x,
        int $y,
        MineField $field,
        ?Unit $transporter = null
    ): bool;
}
