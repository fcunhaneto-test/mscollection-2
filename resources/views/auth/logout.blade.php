@extends('layouts.app')

@section('title', 'Logout')

@section('navbar')
    @component('components.navbar', ['media' => $media])@endcomponent
@endsection

@section('content')
    <auth></auth>
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection
