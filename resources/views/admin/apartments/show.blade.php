@extends('layouts.app')

@section('title', 'Appartamento')

@section('content')

{{-- LISTA LINK --}}
<div class="d-flex align-items-center justify-content-between mt-4">
  <nav class="d-flex align-items-center">
      <ol class="breadcrumb m-0">
          <li><span><i class="fa-solid fa-chevron-left me-2 fs-5 mt-1"></i></span></li>
          <li class="breadcrumb-item"><a class="color-link" href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item"><a class="color-link" href="{{ route('admin.apartments.index') }}">Appartamenti</a></li>
          <li class="breadcrumb-item active" aria-current="page">
              Dettaglio appartamento
          </li>
      </ol>
  </nav>
  {{-- Modifica --}}
  <a href="{{route('admin.apartments.edit', $apartment->id)}}" class="btn bg-hover text-white p-2"><i class="fa-regular fa-pen-to-square me-2"></i> Modifica</a>

</div>
  <div class="row mt-5">
    <div class="col-8">
      <section id="detail">
        <div class="card rounded-4   p-4">

          {{-- Titolo appartamento --}}
          <h1 class="mb-4">{{$apartment->title}}</h1>

          {{-- Immagine di copertina --}}
          <div class="thumb-img">
            <img src="{{$apartment->cover}}" alt="{{$apartment->title}}" class="img-fluid">
          </div>
          <div class="card-body">

            {{-- Descrizione appartamento --}}
            <h2 class="card-title mb-3">Descrizione appartamento</h2>
            <p class="card-text">
              {{$apartment->description}}
              {{-- Indirizzo --}}
              <div class="road fw-bold"><i class="fa-solid fa-location-dot me-2"></i>{{$apartment->address}}</div>
            </p>

            {{-- Dettaglio appartamento --}}
            <h2 class="card-title mt-5 mb-2">Dettaglio appartamento</h2>
            <div class="fw-medium stats mb-2">Come è composto</div>
            <ul class="d-flex gap-3">
              <li>
                <span class="badge fw-medium"><i class="fa-solid fa-door-closed me-2"></i> {{$apartment->rooms}} camere</span>
              </li>
              <li>
                <span class="badge fw-medium"><i class="fa-solid fa-bath me-2"></i> {{$apartment->bathrooms}} bagni</span>
              </li>
              <li>
                <span class="badge fw-medium"><i class="fa-solid fa-ruler-horizontal me-2"></i> {{$apartment->sqm}} mq</span>
              </li>
              <li>
                <span class="badge fw-medium"><i class="fa-solid fa-bed me-2"></i> {{$apartment->rooms}} letti</span>
              </li>
            </ul>
            {{-- Statistiche --}}
          <div class="fw-medium stats mt-4 mb-2">Statistiche</div>
          <ul class="d-flex gap-3">
              <li>
                  <span class="badge fw-medium"><i class="fa-regular fa-eye me-2"></i> {{$apartment->viewsCount()}}</span>
              </li>
              <li>
                  <span class="badge fw-medium"><i class="fa-regular fa-envelope me-2"></i>{{$apartment->messagesCount()}}</span>
              </li>
          </ul>

            {{-- Stato pubblicazione --}}
            <div class="mt-5 fs-5">{!!$apartment->is_visible ? '<i class="fa-solid fa-circle-check text-success me-2"></i> <span class="text-success fw-bold">Pubblicato</span>' : '<i class="fa-solid fa-circle-xmark text-danger"></i> <span class="text-danger fw-bold">Non pubblicato</span>'!!}</div>
          </div>
        </div>
      </section>
    </div>
    <div class="col-4">
      <section id="services">
        <div class="card rounded-4 p-3">
          <div class="card-body">
            <h2 class="card-title mb-4">Servizi appartamento</h2>
            <ul class="p-0 m-0">
            @foreach ($services as $service)
            {{-- <li class="fw-medium mb-3"><img src="" alt="">{{$service->label}}</li> --}}
            @if ($apartment->services->contains($service))
            <li class="fw-medium mb-3 d-flex gap-3 align-items-center fs-5">
              <i class="fa-solid fa-circle-check icon-show"></i>
              <span class="material-symbols-outlined">{{$service->icon}}</span>
               {{$service->label}}
            </li>
            @else
            <li class="fw-medium mb-3 d-flex gap-3 align-items-center fs-5 disable">
              <i class="fa-regular fa-circle text-secondary"></i>
              <span class="material-symbols-outlined ">{{$service->icon}}</span>
               {{$service->label}}
            </li>
            @endif
          @endforeach
            </ul>
          </div>
        </div>
      </section>

      <section id="promo">
        <div class="card rounded-4 mt-4">
          <div class="card-body">
            <div class="card-title d-flex align-items-center gap-2">
              <div class="card-image">
                <img src="{{Vite::asset('resources/img/logo.png')}}" alt="nav-logo">
              </div>
              <h3 class="fw-bolder m-0">BoolBNB Plus</h3>
            </div>
            <p class="fw-bold mt-3">Prova Airbnb Plus e scopri i vantaggi dei nostri piani</p>
            <div class="d-flex justify-content-end">
              <a href="{{route('sponsors.index')}}" class="btn bg-hover text-white p-2 mt-3">Scopri i piani</a>
            </div>
          </div>
        </div>
      </section>

      <section id="sponsor">
        <div class="card rounded-4 p-3 mt-4">
          <div class="card-body">
            <h2 class="card-title mb-4">Sponsorizzazione</h2>
            <div>
              <div class="fw-bold mb-1">Abbonamento trimestrale a <span class="sponsor-type">Airbnb Gold</span></div>
              <p>Il prossimo pagamento sarà di €31,98 il 4 Aprile 2023</p>
            </div>
            <div class="subscription fw-bold"><i class="fa-regular fa-circle-check"></i> Ti sei abbonato ad Airbnb Gold</div>
            <div class="mb-3">
              <a href="{{route('sponsors.index')}}" class="btn bg-hover text-white p-2 mt-3 me-2">Cambia piano</a>
              <a href="" class="btn c-main bg-hover-rev p-2 mt-3">Descrizione abbonamento</a>
            </div>
            <a href="" class="remove-subscription">Disdici abbonamento</a>
          </div>
      </section>
    </div>
  </div>
@endsection