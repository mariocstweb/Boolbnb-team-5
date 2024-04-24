@extends('layouts.app')
@section('content')


{{-- Pagina benvenuto da loggato --}}
@auth
@include('admin.dashboard')
@endauth


@guest
@section('login-form')
  @include('auth.login')
@endsection
@endguest
@endsection

