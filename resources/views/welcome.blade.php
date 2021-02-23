<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
        <title>Weather Application</title>
    </head>
    <body class="bg-blue-500">
        <div class="relative max-w-2xl w-100 my-10 px-0 py-10 bg-white shadow-lg rounded-3xl sm:max-w-xl sm:mx-auto">
            <div class="max-w-lg mx-auto">
                <div id="homePage"></div>
            </div>
        </div>
    </body>
    <script src="{{ asset('js/app.js') }}" ></script>
</html>
