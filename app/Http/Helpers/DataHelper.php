<?php

use App\Models\Game;

/**
 * @param string $status
 * @return string
 */
function prepareGameStatus(?string $status)
{
    switch ($status) {
        case Game::STATUS_WIN:
            $result = 'Победа';
            break;
        case Game::STATUS_LOOSE:
            $result = 'Поражение';
            break;
        case Game::STATUS_TIE:
            $result = 'Ничья';
            break;
        default:
            $result = 'Игра не завершена!';
            break;
    }

    return $result;
}

/**
 * @param $turns
 * @param int|null $last_turn
 * @return array
 */
function prepareBoard($turns, ?int $last_turn = null)
{
    $board = [0, 1, 2, 3, 4, 5, 6, 7, 8];

    if (!empty($turns)) {
        foreach ($turns as $i => $turn) {
            if (!is_null($last_turn) && $i == $last_turn) {
                break;
            }
            $board[$turn['location']] = (string) $turn['player_sign'];
        }
    }

    return $board;
}

/**
 * @param null|string $difficulty
 * @return string
 */
function prepareGameDifficulty(?string $difficulty)
{
    switch ($difficulty) {
        case Game::DIFFICULTY_EASY:
            $result = 'Легко';
            break;
        case Game::DIFFICULTY_HARD:
            $result = 'Сложно';
            break;
        default:
            $result = 'Неизвестная сложность';
            break;
    }

    return $result;
}