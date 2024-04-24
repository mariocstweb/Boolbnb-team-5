@extends('layouts.app')

@section('title', 'Sponsor')

@section('content')
{{-- Navigazione pagine --}}
<nav class="mt-4">
  <ol class="breadcrumb">
      <li><span><i class="fa-solid fa-chevron-left me-2 fs-5 mt-1"></i></span></li>
      <li class="breadcrumb-item"><a class="color-link" href="{{ route('admin.apartments.index') }}">Appartamenti</a></li>
      <li class="breadcrumb-item active" aria-current="page">
        Promo
      </li>
  </ol>
</nav>

<img src="{{Vite::asset('resources/img/plus.png')}}" alt="" class="img-fluid mt-4">
<h3 class="my-4">Acquista uno dei nostri pacchetti e ottieni dei vantaggi esclusivi sui tuoi appartamenti</h3>
<div class="row">
  @foreach ($sponsors as $sponsor)
  <div class="col">
    <div class="card text-white p-3 border-0 rounded-4" style="background-image: linear-gradient(to left,{{$sponsor->color}})">
      <div class="card-body">
        <h1 class="card-title mb-3">{{$sponsor->label}}</h1>
        <p class="card-subtitle mb-4 fs-4">{{$sponsor->description}}</p>
        <p class="card-text fs-4"><strong class="fs-1">{{$sponsor->price}}€</strong> per {{$sponsor->duration}}/h</p>
        <div class="bg-white rounded">
          <a href="" class="btn w-100 fs-4 " style="background-image: linear-gradient(to left,{{$sponsor->color}});-webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-weight: 700;">Passaa pro</a>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>
        

@endsection