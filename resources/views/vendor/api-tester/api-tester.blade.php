<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="token" content="{{ csrf_token() }}">
    <meta name="firebase" content="{{ $firebaseToken }}">
    <base href="{{ url(config('api-tester.route')).'/' }}">
    <link media="all" type="text/css" rel="stylesheet"
          href="{{ route('api-tester.file', ['file' => 'api-tester.css']) }}">
    <title>Laravel api tester</title>
    <meta name="description"
          content="Laravel library to test routes like a boss. Search routes, send requests, analyze responses - everything with nice GUI.">
    <link rel=”author” href=”https://github.com/greabock”/>
    <link rel=”author” href=”https://github.com/asvae”/>
</head>
<body>
<div id="api-tester">
    <vm-api-tester-main></vm-api-tester-main>
</div>
<script src="{{ route('api-tester.file', ['file' => 'api-tester.js']) }}"></script>

{{-- Github page ling --}}
<div class="back-to-repo">
    <a class="button is-active"
       href="https://github.com/asvae/laravel-api-tester"
    >
          <span class="icon">
            <i class="fa fa-github"></i>
          </span>
          <span>GitHub</span>
    </a>
</div>
<style>
    div.back-to-repo {
        position: fixed;
        bottom: 15px;
        right: 15px;
        z-index: 10;
        background-color: rgba(255, 255, 255, 0.57);
    }
</style>

</body>
</html>
