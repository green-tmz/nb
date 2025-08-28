<?php

require_once __DIR__ . '/vendor/autoload.php';

use classes\BTR;
use classes\Cannon;
use classes\Game;
use classes\Soldier;
use classes\Tank;
use factories\UnitFactory;

$config = require __DIR__ . '/config.php';

$game = new Game();

$unitCount = rand(5, $config['unit_count']);
$units = UnitFactory::createMultipleUnits($unitCount);

// Добавление юнитов в игру
foreach ($units as $unit) {
    $game->addUnit($unit);
}

echo "Создано юнитов: " . count($units) . "<br>";

// Запуск симуляции
simulateGame($game);

function simulateGame(Game $game): void
{
    global $config;
    $maxTurns = $config['max_turns'];
    $turn = 1;

    while ($turn <= $maxTurns) {
        echo "=== Ход $turn ===" . "<br>";

        $units = $game->getUnits();

        // Случайные действия для каждого юнита
        foreach ($units as $unit) {
            if ($unit->isDestroyed()) {
                continue;
            }

            performRandomAction($game, $unit, $units);
        }

        // Проверка условия победы
        $victoryMessage = $game->checkVictory();
        if ($victoryMessage !== null) {
            echo $victoryMessage . "<br>";
            break;
        }

        // Статус игры
        echo sprintf(
            "Пересекли поле: %d танков, %d солдат" . "<br>",
            $game->getCrossedTanks(),
            $game->getCrossedSoldiers()
        );

        $turn++;
        usleep(500000);
    }

    if ($turn > $maxTurns) {
        echo "\nИгра завершена по достижению максимального количества ходов." . "<br>";
    }
}

function performRandomAction(Game $game, object $unit, array $allUnits): void
{
    $actions = ['move', 'load', 'shoot', 'wait'];
    $action = $actions[array_rand($actions)];

    try {
        switch ($action) {
            case 'move':
                $x = rand(0, 12);
                $y = rand(0, 12);
                if ($game->moveUnit($unit, $x, $y)) {
                    echo $unit->getType() . " переместился в ($x, $y)<br>";
                } else {
                    if (!$unit->canMove()) {
                        echo $unit->getType() . " не может двигаться<br>";
                    } else {
                        echo $unit->getType() . " не смог переместиться (мина или уничтожен)<br>";
                    }
                }
                break;

            case 'load':
                if ($unit instanceof BTR) {
                    $loadableUnits = array_filter($allUnits, function($u) use ($unit) {
                        return $u !== $unit &&
                            !$u->isDestroyed() &&
                            ($u instanceof Soldier || $u instanceof Cannon) &&
                            abs($u->getPosition()['x'] - $unit->getPosition()['x']) <= 1 &&
                            abs($u->getPosition()['y'] - $unit->getPosition()['y']) <= 1;
                    });

                    if (!empty($loadableUnits)) {
                        $target = $loadableUnits[array_rand($loadableUnits)];
                        if ($unit->load($target)) {
                            echo $unit->getType() . " загрузил " . $target->getType() . "<br>";
                        } else {
                            echo $unit->getType() . " не смог загрузить " . $target->getType() . "<br>";
                        }
                    } else {
                        echo $unit->getType() . ": нет подходящих юнитов для загрузки<br>";
                    }
                }
                break;

            case 'shoot':
                if ($unit->shoot()) {
                    echo $unit->getType() . " произвел выстрел<br>";
                } else {
                    echo $unit->getType() . " не может стрелять (уничтожен)<br>";
                }
                break;

            case 'wait':
                echo $unit->getType() . " пропускает ход<br>";
                break;
        }
    } catch (Exception $e) {
        echo "Ошибка действия: " . $e->getMessage() . "<br>";
    }
}

// Финальная статистика
echo "=== ФИНАЛЬНАЯ СТАТИСТИКА ===" . "<br>";
echo sprintf(
    "Танков пересекло: %d" . "<br>" . "Солдат пересекло: %d" . "<br>",
    $game->getCrossedTanks(),
    $game->getCrossedSoldiers()
);