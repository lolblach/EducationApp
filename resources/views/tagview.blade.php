@extends('layouts/main')

@section('content')
    <div style="width: 100%; display: flex; flex-direction: column; align-items: center; padding: 50px; row-gap: 20px">
        <div style="padding: 20px; background-color: #98e295ed; border-radius: 10px; box-shadow: 5px 5px 5px; display: flex; flex-direction: column; row-gap: 20px">
            @if (count($posts) > 0)
                <h1 style="width: 100%; text-align: center; margin-bottom: 50px">{{ $tagName }}</h1>
                @for ($i = 0; $i < count($posts); $i++)
                    <div style="display: flex; align-items: center; width: 800px; justify-content: space-between">
                        <div style="display: flex; column-gap: 20px; align-items: center">
                            <div style="width: 325px; font-size: 20px">
                                {{ mb_strimwidth($posts[$i]->title, 0, 30) }}@if (iconv_strlen($posts[$i]->title) > 30)...@endif
                            </div>
                            <div style="width: 200px; height: 20px; background-color: #6ad0a0; border-radius: 5px; overflow: hidden">
                                <div style="width: {{ $progress[$i] }}%; height: 100%; background-color: #00a83d; line-height: 20px; font-weight: bold; text-align: center">{{ $progress[$i] }}%</div>
                            </div>
                        </div>
                        <a href="{{ route('post.view', ['id' => $posts[$i]->id]) }}" class="btn btn-success">Начать</a>
                    </div>
                @endfor
            @else
                <div style="padding: 0px 50px"><h1>Уроков пока нет :(</h1></div>
            @endif
        </div>
    </div>
@endsection
