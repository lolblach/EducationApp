@extends('layouts/main')

<script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">
    bkLib.onDomLoaded(nicEditors.allTextAreas);
</script>

@section('content')
    <div style="display: flex; flex-direction: column; align-items: center; row-gap: 30px; width: 100%">
        <br>
        <form style="display: flex; flex-direction: column; align-items: center; row-gap: 30px; padding: 20px; box-shadow: 5px 5px 5px; background-color: #98e295ed; border-radius: 10px" action="{{ route('post.createaction') }}" method="POST">
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
            @csrf
            <div style="font-size: 2rem">Создать урок</div>
            <input type="text" name="title" placeholder="Заголовок" class="form-control">
            <div style="background-color: white">
                <textarea name="content" cols="150" rows="20">
                    @if (session('content') != null) {{ session('content') }} @endif
                </textarea>
            </div>
            <select class="form-control" name="tag">
                <option value="">Не выбрано</option>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-success">Создать</button>
        </form>
    </div>
@endsection
