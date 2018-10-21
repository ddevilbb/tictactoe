@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Крестики - нолики</h1>
        <div class="alert alert-warning">
            <p><b>Правила игры</b>: игроки по очереди ставят на свободные клетки поля 3х3 знаки (один всегда крестики, другой всегда нолики). Первый, выстроивший в ряд 3 своих фигуры по вертикали, горизонтали или диагонали, выигрывает. Первый ход делает игрок, ставящий крестики.</p>
        </div>
    </div>
@endsection