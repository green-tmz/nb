<?php

declare(strict_types=1);

namespace factories;

use classes\BTR;
use classes\Cannon;
use classes\Soldier;
use classes\Tank;
use classes\Unit;

class UnitFactory
{
    /**
     * @return Unit
     */
    public static function createRandomUnit(): Unit
    {
        $unitTypes = [
            BTR::class,
            Soldier::class,
            Cannon::class,
            Tank::class
        ];
        $randomType = $unitTypes[array_rand($unitTypes)];

        return new $randomType(rand(0, 10), rand(0, 10));
    }

    /**
     * @return Unit[]
     */
    public static function createMultipleUnits(int $count): array
    {
        $units = [];
        for ($i = 0; $i < $count; ++$i) {
            $units[] = self::createRandomUnit();
        }

        return $units;
    }
}
