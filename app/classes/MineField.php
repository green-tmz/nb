<?php

declare(strict_types=1);

namespace classes;

use Random\RandomException;

readonly class MineField
{
    private const int WIDTH = 10;
    private const int HEIGHT = 10;
    private const float MINE_DENSITY = 0.2;

    /**
     * @var array<int, array<int, bool>>
     */
    private array $mines;

    public function __construct()
    {
        $this->mines = $this->generateMines();
    }

    /**
     * @return array<int, array<int, bool>>
     * @throws RandomException
     */
    private function generateMines(): array
    {
        $mines = [];
        $totalCells = self::WIDTH * self::HEIGHT;
        $mineCount = (int) ($totalCells * self::MINE_DENSITY);

        for ($i = 0; $i < $mineCount; ++$i) {
            $x = random_int(0, self::WIDTH - 1);
            $y = random_int(0, self::HEIGHT - 1);
            $mines[$x][$y] = true;
        }

        return $mines;
    }

    public function hasMine(int $x, int $y): bool
    {
        return isset($this->mines[$x][$y]);
    }

    public function getWidth(): int
    {
        return self::WIDTH;
    }

    public function getHeight(): int
    {
        return self::HEIGHT;
    }
}
