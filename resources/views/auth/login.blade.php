@extends('layouts.app')

@section('title', 'Login')

@section('navbar')
    @component('components.navbar', ['media' => $media])@endcomponent
@endsection

@section('content')
    <auth></auth>
@endsection
