@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <h2>Выберите роль</h2>
        <form action="{{ route('save_sign') }}" method="post">
            @csrf
            <div class="form-group">
                <div class="form-check form-check-inline">
                    <input id="radio-sign-x" class="form-check-input" type="radio" name="sign" value="x" checked/>
                    <label class="form-check-label" for="radio-sign-x">
                        <span class="sign-x">X</span>
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input id="radio-sign-o" class="form-check-input" type="radio" name="sign" value="o"/>
                    <label class="form-check-label" for="radio-sign-o">
                        <span class="sign-o">O</span>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-sm btn-primary" value="Начать игру"/>
            </div>
        </form>
    </div>
@endsection
