@extends('layouts.app')
 
@section('header')
    @component('components.header', ['data' => $data->header])
    @endcomponent
@endsection

@section('main')
    @parent
    @component('components.books', ['data' => $data])
    @endcomponent
@endsection
@section('footer')
    @component('components.footer', ['data' => $data->footer])
    @endcomponent
@endsection