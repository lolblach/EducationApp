@extends('layouts/default')
    <style>
        .reglink {
            color:black;
            text-decoration: none;
        }
        .reglink:hover {
            text-decoration: underline;
            color: black;
        }
    </style>
@section('content')
    <form action="{{ route('user.register') }}" method="POST" style="display: flex; flex-direction: column; row-gap: 10px; width: 400px; padding: 20px; box-shadow: 5px 5px 5px; background-color: #98e295ed; border-radius: 10px">
        @csrf
        <div style="width: 100%; text-align: center;">
            @if (session()->has('success'))
                <div style="background-color: #a4cfa4; padding: 10px; border-radius: 5px">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div style="background-color: #ffa6a6; padding: 10px; border-radius: 5px">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
        </div>
        <br>
        <h1 style="width: 100%; text-align:center">Регистрация</h1>
        <br>
        <input name="name" type="text" class="form-control" placeholder="Придумайте имя">
        <input name="password" type="password" class="form-control" placeholder="Придумайте пароль">
        <input name="repeat-password" type="password" class="form-control" placeholder="Повторите пароль">
        <button class="btn btn-success">Войти</button>
        <a href="{{ route('user.loginpage') }}" class="reglink">Уже есть аккаунт? Войти!</a>
    </form>
@endsection