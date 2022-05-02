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
            <li class="list-group-item verse-style" aria-current="true">
                <p class="chapter-content verse-style-content">
                    <sup class="text-muted verse-style-num">{{ $data->verse_data[0]->num }}</sup>
                    {{ $data->verse_data[0]->content }}
                </p>
            </li>
        </ul>
    </div>
    @component('components.button_left_right', ['data' => $data->left_right])
    @endcomponent
@endsection
@section('footer')
    @component('components.footer', ['data' => $data->footer])
    @endcomponent
@endsection