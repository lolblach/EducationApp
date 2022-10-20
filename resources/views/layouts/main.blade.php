<!DOCTYPE html>
<html lang="ru">

<head>
    <style>
        ::-webkit-scrollbar {
            width: 0;
        }
    </style>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Education</title>
</head>

<body style="font-family: Roboto; background-image: url({{ url('/storage/images/pattern.jpg') }})">
    <div style="margin: 0px; padding: 0px 50px; width: 100vw; height: 50px; background-color:#198754f2; border: solid 1px #198754; display: flex; justify-content: space-between; align-items: center; box-shadow: 5px 5px 5px">
        <div style="display: flex; column-gap: 20px">
            <a style="font-size: 30px; text-decoration: none; color: black" href="/">Ed</a>
        </div>
        <div class="dropdown">
            <a href="" style="text-decoration: none; color: black; font-size: 20px" data-bs-toggle="dropdown" aria-expanded="false">
                Menu <span style="font-size: 1rem">▼</span>
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('user.profile') }}">Личный кабинет</a></li>
                @if (session('role') == 1)
                    <li><a class="dropdown-item" href="{{ route('tag.index') }}">Редактор тем</a></li>
                @endif
                @if (session('role') == 1)
                    <li><a class="dropdown-item" href="{{ route('post.createpage') }}">Создать урок</a></li>
                @endif
                @if (session('role') == 1)
                    <li><a class="dropdown-item" href="{{ route('user.index') }}">Пользователи</a></li>
                @endif
                <li><a class="dropdown-item" href="{{ route('user.logout') }}">Выйти</a></li>
            </ul>
        </div>
    </div>
    <div style="width: 100vw; height: calc(100vh - 50px); max-width: 100vw; max-height: calc(100vh - 50px); overflow: scroll">
        @yield('content')
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

</html>
