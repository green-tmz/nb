<?php

declare(strict_types=1);

namespace Tests\Unit;

use classes\Soldier;
use classes\MineField;
use PHPUnit\Framework\TestCase;

class UnitTest extends TestCase
{
    public function testSoldierCreation(): void
    {
        $soldier = new Soldier(5, 5);

        $this->assertInstanceOf(Soldier::class, $soldier);
        $this->assertSame('Soldier', $soldier->getType());
        $this->assertTrue($soldier->canShoot());
        $this->assertTrue($soldier->canMove());
    }

    public function testSoldierMove(): void
    {
        $soldier = new Soldier(0, 0);
        $mineField = new MineField();

        $result = $soldier->move(2, 3, $mineField);

        $this->assertTrue($result);
        $this->assertSame(2, $soldier->getX());
        $this->assertSame(3, $soldier->getY());
    }

    public function testSoldierShoot(): void
    {
        $soldier = new Soldier(0, 0);

        $result = $soldier->shoot();

        $this->assertTrue($result);
    }
}