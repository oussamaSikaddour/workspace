<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title)? $title .' |': '' }}  {{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer">

    <script src="https://cdn.tiny.cloud/1/oe2xz52b1wiacx1ys8xzk5j31bm7r9xsa7ulmo2jg1ikr64l/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    @vite(['resources/css/app.css','resources/js/app.js',])
</head>
<body>




    <livewire:toast />
    <livewire:errors />
    <livewire:modal />
    <livewire:dialog/>
    @yield("content")
</body>
</html>
