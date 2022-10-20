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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EducationApp</title>
</head>

<body style="font-family: Roboto; background-image: url({{ url('/storage/images/pattern.jpg') }})">
    <div style="width: 100vw; height: 100vh; max-width: 100vw; max-height: 100vh; overflow: scroll; display: flex; flex-direction: column; justify-content: center; align-items: center">
        <div>
            @yield('content')
        </div>
    </div>
</body>

</html>
