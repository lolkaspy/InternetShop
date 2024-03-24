@extends('layouts.app')
@section('content')
    @if(Auth::check())
        <div class="container">
        <hr>
        <div><h1>Личный кабинет</h1></div>
        <hr>

        <div>
            <p class="label-14pt">Имя: {{Auth::user()->name}}</p>
            <p class="label-14pt">Email: {{Auth::user()->email}}</p>
            @if(Auth::check() && Auth::user()->role_id == 2)
            <p class="label-14pt">Баланс: {{Auth::user()->balance}}</p>
            @endif
            <p class="label-14pt">Дата регистрации: {{date_format(Auth::user()->created_at, "d.m.Y")}}</p>
        </div>
    </div>
    @else
        <div class="container text-center">
            <hr>
            <p class="label-14pt">Войдите или зарегистрируйтесь, чтобы увидеть содержимое личного кабинета!</p>
            <hr>
        </div>
    @endif

@endsection

