@extends('layouts.app')

@section('title', 'Appartamento')

@section('content')
  <h1 class="text-center">{{$apartment->title}}</h1>
  <div class="d-flex justify-content-center">
    <div class="card mb-3" >
      <div class="row g-0">
        <div class="col-md-4">
          <img src="{{$apartment->cover}}" class="img-fluid rounded-start" alt="">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">{{$apartment->title}}</h5>
            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
            <p><strong>Camere: </strong>{{$apartment->rooms}}</p>
            <p><strong>Letti: </strong>{{$apartment->beds}}</p>
            <p><strong>Bagni: </strong>{{$apartment->bathrooms}}</p>
            <p><strong>Metri quadri:</strong>{{$apartment->sqm}}</p>
            <p><strong>Indirizzo: </strong>{{$apartment->address}}</p>
            <p><strong>Pubblicato: </strong>{{$apartment->is_visible}}</p>
            <a href="{{route('admin.apartments.index')}}" class="btn btn-primary">Torna indietro</a>
            <a href="{{route('admin.apartments.edit', $apartment->id)}}" class="btn btn-sm btn-warning"><i class="fa-regular fa-pen-to-square"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection