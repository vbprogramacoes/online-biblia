@extends('layouts.app')
 
@section('header')
    @component('components.header', ['data' => $data->header])
    @endcomponent
@endsection

@section('main')
    @parent
    <div class="container">
        <h1 class="h1">{{ $data->h1 }}</h1>
        @php
            $amount_lines   = ceil($data->book_data->chapters / 10);
            $amount_chapters = $data->book_data->chapters;
            $version    = $data->version;
            $book_aab   = $data->book_data->abbreviation_url;
        @endphp
        @for($count_lines = 0; $count_lines < $amount_lines; $count_lines++)
        <ul class="list-group list-group-horizontal">
            @for($count_verses = ($count_lines * 10) + 1; ($count_verses <= (($count_lines + 1) * 10)) && ($count_verses <= $amount_chapters ); $count_verses++)
                @php
                    $url = "$version/$book_aab/$count_verses";
                @endphp
                <li class="list-group-item verse-field">
                    <a class="group-verse" href="{{ url($url) }}">{{ $count_verses }}</a>
                </li>
            @endfor
        </ul>
        @endfor
    </div>
@endsection
@section('footer')
    @component('components.footer', ['data' => $data->footer])
    @endcomponent
@endsection