@extends('layouts.app')
@section('header')
    @component('components.header', ['data' => $data->header])
    @endcomponent
@endsection

@section('main')
    @parent
    <div class="container">
        <h1 class="h1">{{ $data->h1 }}</h1>
        <ul class="list-group">
            @foreach ($data->verses_data as $key => $verse)
                <li class="list-group-item verse-style" aria-current="true">
                    <p class="chapter-content verse-style-content">
                        <sup class="text-muted verse-style-num">{{ $verse->num}}</sup>
                        {{ $verse->content }}
                    </p>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
@section('footer')
    @component('components.footer', ['data' => $data->footer])
    @endcomponent
@endsection