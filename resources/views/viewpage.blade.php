@extends('layouts/main')

@section('content')
    <div style="display: flex; flex-direction: column; width: 100%">
        <div style="margin: 20px 100px; padding: 20px; background-color: #caf5c8; border-radius: 10px; box-shadow: 5px 5px 5px; display: flex; flex-direction: column; align-items: center; row-gap: 50px">
            <div style="word-break: break-all"><?php echo $post->content; ?></div>
            <a class="btn btn-success" href="{{ route('test.view', ['id' => $post->id]) }}">Пройти тест</a>
            @if (session('role') == 1)
                <a class="btn btn-danger" href="{{ route('post.delete', ['id' => $post->id]) }}">Удалить урок</a>
            @endif
        </div>
    </div>
@endsection
