<!DOCTYPE html>
<html lang="ptbr">
<head>
    <meta name="languate" content="{{ $data->meta_language }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html; charset={{ $data->meta_content_type }}">
    
    <meta name="title" content="{{ $data->meta_title }}">
    <meta name="description" content="{{ $data->meta_description }}">
    <link rel="canonical" href="{{ $data->canonical }}">
    
    <title>{{ $data->title }}</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">

    <!-- ICON IMAGE -->
    <link href="{{ asset('img/punch.png') }}" rel="icon" type="image/png">

    <!-- CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/modal_bibles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chapter.css') }}" rel="stylesheet">

    <!-- CSS APIs -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    
    
    <!-- JAVASCRIPT APIs -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
    
    <!-- JAVASCRIPT -->
    <script src="{{ asset('js/modal_bibles.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('pre code').each(function (i, block) {
                hljs.highlightBlock(block);
            });
        });

        var url = "{{ url('/') }}";
    </script>
    <meta name="google-site-verification" content="I0ieriBk6AR0VVbNNcE6WUf-jQxtPWdNJm7nLH_rj74" />
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-SQRWKSSJ7S"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-SQRWKSSJ7S');
    </script>
</head>
<body>
    <div class="container-fluid body">
        <header class="header">
            @section('header')
            @show
        </header>
        <main class = "main">
            @section('main')
            @show
        </main>
        <footer class="footer">
            @section('footer')
            @show
        </footer>
    </div>
</body>
</html>
