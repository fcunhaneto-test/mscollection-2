@extends('layouts.app')

@section('title', $header)

@section('navbar')
    @component('components.navbar-admin', ['media' => $media])@endcomponent
@endsection

@can('isAdmin')
    @section('content')
        <admin :subheader="'{{ $subheader }}'" ></admin>
    @endsection
@endcan

@section('footer')
    @component('components.footer-admin')@endcomponent
@endsection
