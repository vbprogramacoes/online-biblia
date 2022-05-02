@extends('layouts.app')

@section('header')
    @component('components.header', ['data' => $data->header])
    @endcomponent
@endsection

@section('main')
    @parent
    <div class="container">
        <h1>@lang('messages.page_not_found')</h1>
        <p>@lang('messages.page_not_found_content').</p>
        <p><a href="/">@lang('messages.return_to_home')</a></p>
    </div>
@endsection
@section('footer')
    @component('components.footer', ['data' => $data->footer])
    @endcomponent
@endsection
