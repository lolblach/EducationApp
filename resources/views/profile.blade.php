@extends('layouts/main')

@section('content')
    <div style="width: 100%; display: flex; flex-direction: column; align-items:center">
        <div style="margin: 100px; background-color: #98e295ed; padding: 20px; border-radius: 10px; box-shadow: 5px 5px 5px">
            <div style="width: 1100px; display: flex; column-gap: 50px">
                <div style="width: 500px; height: 500px; overflow: hidden; border-radius: 20px; display: flex; justify-content: center; align-items: center;">
                    <img style="width: 100%; height: auto; max-height: 500px; border-radius: 20px" @if ($user->image != null) src="{{ url('/storage/images/'.$user->image) }}" @else src="{{ url('/storage/images/noimage.png') }}"  @endif>
                </div>
                <div style="display: flex; flex-direction: column; row-gap: 50px">
                    <div style="display: flex; flex-direction: column">
                        <span style="font-size: 3rem">
                            {{ mb_strimwidth(session('name'), 0, 15) }}@if (iconv_strlen(session('name')) > 15)...@endif
                        </span>
                        <span style="font-size: 1.3rem">{{ $user->role->name }}</span>
                    </div>
                    <div>
                        <form style="display: flex; flex-direction: column; row-gap: 10px" action="{{ route('user.changepass', ['name' => session('name')]) }}" method="POST">
                            @csrf
                            <div style="width: 100%; text-align: center">
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
                            <div style="font-size: 1.4rem">Сменить пароль</div>
                            <input name="password" type="password" class="form-control" placeholder="Старый пароль">
                            <input name="newpassword" type="password" class="form-control" placeholder="Новый пароль">
                            <input name="repeat_newpassword" type="password" class="form-control" placeholder="Повторите новый пароль">
                            <button type="submit" class="btn btn-success">Сменить пароль</button>
                        </form>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column">
                    <h3 style="margin-top: 10px">Аватар профиля<h3>
                    <form style="display: flex; flex-direction: column; row-gap: 10px" action="{{ route('user.image') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" class="form-control" name="file" accept="image/*">
                        <button type="submit" class="btn btn-success">Сменить</button>
                    </form>
                </div>
            </div>
            <div style="width: 1100px; display: flex; flex-direction: column; row-gap: 20px">
                @for ($i = 0; $i < count($tags); $i++)
                    <div style="display: flex; column-gap: 20px; align-items: center">
                        <div style="display: flex; column-gap: 10px">
                            <div style="font-size: 2rem; color:gray">#{{ $i + 1 }}</div>
                            <div style="width: 490px; font-size: 2rem">
                                {{ mb_strimwidth($tags[$i]->name, 0, 30) }}@if (iconv_strlen($tags[$i]->name) > 30)...@endif
                            </div>
                        </div>
                        <div style="display: flex; column-gap: 20px; align-items: center">
                            <div>Прогресс:</div>
                            <div style="width: 400px; height: 20px; background-color: #6ad0a0; border-radius: 5px; overflow: hidden">
                                <div style="width: {{ $progress[$i] }}%; height: 100%; background-color: #00a83d; line-height: 20px; font-weight: bold; text-align: center">{{ $progress[$i] }}%</div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
@endsection
