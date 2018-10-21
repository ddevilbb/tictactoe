@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <h3>Игра #{{ $game->id }}</h3>
        <div class="game-info">
            @if (!empty($game->status))
                @switch ($game->status)
                    @case('win')
                        <div class="alert alert-success">Вы победили!</div>
                        @break
                    @case('loose')
                        <div class="alert alert-danger">Вы проиграли!</div>
                        @break
                    @case('tie')
                        <div class="alert alert-secondary">Ничья!</div>
                        @break
                @endswitch
            @endif
        </div>
        <div class="tic-board-wrapper">
            <div class="row tic-board">
                @for ($i = 0; $i<=8; $i++)
                <div class="col-4 tic-cell{{ is_string($board[$i]) ? ' tic-turn-' . $board[$i] . ' cell-busy' : '' }}" data-location="{{ $i }}"></div>
                @endfor
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ mix('js/board.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
      board.init({
        game:{!! json_encode($game) !!},
        user:{!! json_encode($user) !!}
      });
    })
</script>
@endsection