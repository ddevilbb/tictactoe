@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center">Выберите параметры игры</h2>
        <div class="row">
            <form class="col-sm-6 offset-sm-3 col-12" action="{{ route('save_parameters') }}" method="post">
                @csrf
                <div class="form-group row">
                    <label class="col-form-label-sm col-12">Роль:</label>
                    <div class="col-12">
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
                </div>
                <div class="form-group row">
                    <label class="col-form-label-sm col-12">Сложность:</label>
                    <div class="col-12">
                        <select name="difficulty" class="form-control">
                            <option value="easy">Легко</option>
                            <option value="hard">Сложно</option>
                        </select>
                    </div>
                </div>
                <div class="form-group text-center">
                    <input type="submit" class="btn btn-sm btn-primary" value="Начать игру"/>
                </div>
            </form>
        </div>

    </div>
@endsection
