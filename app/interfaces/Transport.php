<?php

declare(strict_types=1);

namespace interfaces;

use classes\Unit;

interface Transport
{
    public function load(Unit $unit): bool;

    public function unload(): ?Unit;

    public function getLoadedUnit(): ?Unit;

    public function hasLoadedUnit(): bool;
}
