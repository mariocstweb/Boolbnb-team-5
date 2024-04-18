@extends('layouts.app')

@section('title', 'Modifica Appartamento')

@section('content')
  @include('includes.apartment.form')
@endsection

@section('scripts')
@vite('resources/js/image_preview.js')
@endsection