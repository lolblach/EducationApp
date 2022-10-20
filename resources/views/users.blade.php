@extends('layouts/main')

@section('content')
    <div style="display: flex; flex-direction: column; width: 100%; align-items: center; padding: 40px; row-gap: 10px">
        <div style="box-shadow: 5px 5px 5px; padding: 20px; background-color: #98e295ed; border-radius: 10px; display: flex; flex-direction: column; row-gap: 10px">
            @foreach ($users as $user)
                <div style="width: 800px; display: flex; justify-content: space-between; align-items: center">
                    <div style="font-size: 1.5rem">
                        {{ mb_strimwidth($user->name, 0, 35) }}@if (iconv_strlen($user->name) > 35)...@endif
                    </div>
                    @if ($user->role_id == 2)
                        @if ($user->name == session('name'))
                            <a style="width: 300px" href="{{ route('user.changerole', ['id' => $user->id]) }}" role="button" aria-disabled="true" class="btn btn-success disabled">Сделать администратором</a>
                        @else
                            <a style="width: 300px" href="{{ route('user.changerole', ['id' => $user->id]) }}" class="btn btn-success">Сделать администратором</a>
                        @endif
                    @else
                        @if ($user->name == session('name'))
                            <a style="width: 300px" href="{{ route('user.changerole', ['id' => $user->id]) }}" role="button" aria-disabled="true" class="btn btn-danger disabled">Сделать пользователем</a>
                        @else
                            <a style="width: 300px" href="{{ route('user.changerole', ['id' => $user->id]) }}" class="btn btn-danger">Сделать пользователем</a>
                        @endif
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
