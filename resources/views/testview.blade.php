@extends('layouts/main')

@section('content')
    <div style="display: flex; flex-direction: column; width: 100%; align-items: center">
        <div style="display: flex; flex-direction: column; padding: 20px; border-radius: 10px; box-shadow: 5px 5px 5px; background-color: #98e295ed; margin: 50px 0px">
            <div>
                <h1>
                    {{ mb_strimwidth('Тест к уроку "' . $post->title . '"', 0, 60) }}@if (iconv_strlen('Тест к уроку "' . $post->title . '"') > 15)
                        ...
                    @endif
                </h1>
            </div>
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
            <div style="margin: 50px 0px; max-width: 1300px">
                @if (count($tests) > 0)
                    <form action="{{ route('test.confirm', ['id' => $post->id]) }}" method="POST">
                        @csrf
                        @for ($i = 0; $i < count($tests); $i++)
                            @if ($tests[$i]->type_id == 1)
                                <div>
                                    <div style="word-break: break-all; width: 100%">
                                        @if (session('role') == 1)
                                            <div><a style="text-decoration: none; color: red" href="{{ route('test.delete', ['id' => $tests[$i]->id]) }}">Удалить</a></div>
                                        @endif
                                        <h5>{{ $tests[$i]->text }}</h5>
                                    </div>

                                    <select name="ans{{ $tests[$i]->id }}" class="form-control">
                                        <option value="">Выберите ответ</option>
                                        @if ($tests[$i]->ans1 != null)
                                            <option value="1">{{ $tests[$i]->ans1 }}</option>
                                        @endif
                                        @if ($tests[$i]->ans2 != null)
                                            <option value="2">{{ $tests[$i]->ans2 }}</option>
                                        @endif
                                        @if ($tests[$i]->ans3 != null)
                                            <option value="3">{{ $tests[$i]->ans3 }}</option>
                                        @endif
                                        @if ($tests[$i]->ans4 != null)
                                            <option value="4">{{ $tests[$i]->ans4 }}</option>
                                        @endif
                                    </select>
                                </div>
                            @endif
                            @if ($tests[$i]->type_id == 2)
                                <div>
                                    @if (session('role') == 1)
                                        <div><a style="text-decoration: none; color: red" href="{{ route('test.delete', ['id' => $tests[$i]->id]) }}">Удалить</a></div>
                                    @endif
                                    <h5>{{ $tests[$i]->text }}</h5>
                                    <input type="text" placeholder="Ответ" name="ans{{ $tests[$i]->id }}" class="form-control">
                                </div>
                            @endif
                            <br>
                        @endfor
                        <button type="submit" class="btn btn-success" style="width: 100%">Отправить</button>
                    </form>
                @else
                    <div style="width: 100%; text-align: center; font-size: 1.3rem">Вопросов нет!</div>
                @endif
            </div>
            @if (session('role') == 1)
                <div>
                    <form action="{{ route('test.add', ['id' => $post->id]) }}" method="POST" style="display: flex; flex-direction: column; align-items: center; row-gap: 10px;">
                        @csrf
                        <h3>Добавить вопрос</h3>
                        <input type="text" name="ask" placeholder="Введите вопрос" class="form-control">
                        <select name="type" class="form-control">
                            <option value="">Выберите тип вопроса</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                            <input type="text" class="form-control" name="right" placeholder="Правильный ответ">
                            <input type="text" class="form-control" name="ans1" placeholder="Вариант ответа №1">
                            <input type="text" class="form-control" name="ans2" placeholder="Вариант ответа №2">
                            <input type="text" class="form-control" name="ans3" placeholder="Вариант ответа №3">
                            <input type="text" class="form-control" name="ans4" placeholder="Вариант ответа №4">
                            <button type="submit" style="width: 100%" class="btn btn-success">Добавить</button>
                        </select>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
