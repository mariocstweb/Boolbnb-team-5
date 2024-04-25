@extends('layouts.app')

@section('content')

    {{-- UTENTE AUTENTICATO --}}
    @auth
        {{-- INCLUDO PANNELLO DI CONTROLLO --}}
        @include('admin.dashboard')
    @endauth



    {{-- UTENTE NON AUTENTICATO --}}
    @guest

    @section('title', 'Login')

    @section('login-form')
        {{-- INCLUDO LOGIN --}}
        @include('auth.login')
    @endsection
@endguest

@endsection
