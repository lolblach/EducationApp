@extends('layouts/main')

@section('content')
    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 100%;">
        <div style="padding: 20px; box-shadow: 5px 5px 5px; background-color: #98e295ed; border-radius: 10px; display: flex; flex-direction: column; align-items: center; margin: 50px 0px">
            <br>
            <form style="display:flex; flex-direction: column; row-gap: 10px; width: 500px" action="{{ route('tag.create') }}" method="POST">
                @csrf
                <div style="width: 100%; text-align: center;">
                    @if (session()->has('success'))
                        <div style="background-color: #a4cfa4; padding: 10px; border-radius: 5px">
                            {{ session()->get('success') }}
                        </div>
                        <br>
                    @endif
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div style="background-color: #ffa6a6; padding: 10px; border-radius: 5px">
                                {{ $error }}
                            </div>
                        @endforeach
                        <br>
                    @endif
                </div>
                <input type="text" name="name" class="form-control" placeholder="Название темы">
                <button type="submit" class="btn btn-success">Создать</button>
            </form>
            @if (count($tags) > 0)
                <div style="width: 100%; display: flex; flex-direction: column; row-gap: 10px; margin: 50px 0px 20px 0px">
                    @foreach ($tags as $tag)
                        <div style="width: 100%; display: flex; align-items: center; justify-content: space-between">
                            <div style="font-size: 1.3rem; padding-right: 20px">
                                {{ mb_strimwidth($tag->name, 0, 80) }}@if (iconv_strlen($tag->name) > 80)...@endif
                            </div>
                            <div>
                                <a href="{{ route('tag.delete', ['id' => $tag->id]) }}" class="btn btn-danger">Удалить</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
