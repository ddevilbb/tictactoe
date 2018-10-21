<?php

/**
 * @param string $status
 * @return string
 */
function prepareGameStatus(?string $status)
{
    switch ($status) {
        case 'win':
            $result = 'Победа';
            break;
        case 'loose':
            $result = 'Поражение';
            break;
        case 'tie':
            $result = 'Ничья';
            break;
        default:
            $result = 'Игра не завершена!';
            break;
    }

    return $result;
}

function prepareBoard($turns, ?int $last_turn = null)
{
    $board = [0, 1, 2, 3, 4, 5, 6, 7, 8];

    if (!empty($turns)) {
        foreach ($turns as $i => $turn) {
            if (!is_null($last_turn) && $i == $last_turn) {
                break;
            }
            $board[$turn['location']] = (string) $turn['player_type'];
        }
    }

    return $board;
}