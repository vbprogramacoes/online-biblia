@extends('layouts.app')
<div class="container header-nav">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand mb-0 logo" href="{{ url('') }}">@lang('messages.onlinebible')</a>
        </div>
        <div class="container-fluid d-none"></div>
    </nav>
</div>
@section('main')
    @parent
    <div class="container">
        <h1>@lang('messages.page_not_found')</h1>
        <p>@lang('messages.page_not_found_content').</p>
        <p><a href="/">@lang('messages.return_to_home')</a></p>
    </div>
@endsection
