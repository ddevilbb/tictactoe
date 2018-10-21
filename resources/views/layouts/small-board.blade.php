<div class="small-tic-board-wrapper">
    <div class="row small-tic-board">
        @for ($i = 0; $i<=8; $i++)
            <div class="col-4 tic-cell{{ is_string($board[$i]) ? ' tic-turn-' . $board[$i] . ' cell-busy' : '' }}"></div>
        @endfor
    </div>
</div>

