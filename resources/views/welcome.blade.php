<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <title>Weather Application</title>
    </head>
    <body class="bg-blue-500">
        <div class="relative max-w-2xl w-100 my-10 px-0 py-10 bg-white shadow-lg rounded-3xl sm:max-w-xl sm:mx-auto">
            <div class="max-w-md mx-auto">
                <div id="homePage"></div>
            </div>
        </div>
    </body>
    <script src="{{ asset('js/app.js') }}" ></script>
</html>
