<?php

declare(strict_types=1);

namespace classes;

use interfaces\Movable;

final class Game
{
    private MineField $mineField;

    /**
     * @var Unit[]
     */
    private array $units = [];
    private int $crossedTanks = 0;
    private int $crossedSoldiers = 0;

    public function __construct()
    {
        $this->mineField = new MineField();
        $this->initializeUnits();
    }

    private function initializeUnits(): void
    {
        $this->units = [
            ...array_map(fn () => new BTR(0, 0), range(1, 3)),
            ...array_map(fn () => new Tank(0, 0), range(1, 2)),
            ...array_map(fn () => new Soldier(0, 0), range(1, 4)),
            ...array_map(fn () => new Cannon(0, 0), range(1, 2)),
        ];
    }

    public function checkVictory(): ?string
    {
        return match (true) {
            $this->crossedTanks >= 2 => 'Победа! 2 танка пересекли минное поле!',
            $this->crossedSoldiers >= 4 => 'Победа! 4 солдата пересекли минное поле!',
            default => null,
        };
    }

    public function moveUnit(Unit $unit, int $x, int $y): bool
    {
        if (!$unit->canMove() || !$unit instanceof Movable) {
            return false;
        }

        $success = $unit->move($x, $y, $this->mineField);

        if ($success && $y >= $this->mineField->getHeight()) {
            match (true) {
                $unit instanceof Tank => $this->crossedTanks++,
                $unit instanceof Soldier => $this->crossedSoldiers++,
                default => null,
            };
        }

        return $success;
    }

    /**
     * @return Unit[]
     */
    public function getUnits(): array
    {
        return $this->units;
    }

    public function getCrossedTanks(): int
    {
        return $this->crossedTanks;
    }

    public function getCrossedSoldiers(): int
    {
        return $this->crossedSoldiers;
    }

    /**
     * @param Unit $unit
     * @return void
     */
    public function addUnit(Unit $unit): void
    {
        $this->units[] = $unit;
    }
}
