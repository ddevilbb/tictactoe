<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th width="10">#</th>
            <th>Игра</th>
            <th>Сложность</th>
            <th>Статус</th>
            <th width="40">Доска</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($games as $game)
            <tr>
                <td>
                    <span class="toggle-turns" data-game-id="{{ $game->id }}"></span>
                </td>
                <td>Игра #{{ $game->id }}</td>
                <td>{{ prepareGameDifficulty($game->difficulty) }}</td>
                <td>{{ prepareGameStatus($game->status) }}</td>
                <td>
                    @include('layouts.small-board', ['board' => prepareBoard($game->turns)])
                </td>
            </tr>
            <tr class="table-active hidden-table-row" data-game-id="{{ $game->id }}">
                <td colspan="5">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Ход</th>
                                <th>Игрок</th>
                                <th width="40">Доска</th>
                            </tr>
                        </thead>
                        @foreach ($game->turns as $i => $turn)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $turn->player_id === $user->id ? 'Вы' : 'AI' }}</td>
                                <td>
                                    @include('layouts.small-board', ['board' => prepareBoard($game->turns, $i)])
                                </td>
                            </tr>
                        @endforeach
                    </table>

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">
                    <p class="text-center">Не сыграно ни одной игры!</p>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
