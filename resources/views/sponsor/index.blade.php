@extends('layouts.app')

@section('title', 'Sponsor')

@section('content')
  <img src="{{Vite::asset('resources/img/plus.png')}}" alt="" class="img-fluid mt-4">
  <h5 class="mt-3">Acquista uno dei nostri pacchetti e ottieni dei vantaggi esclusivi sui tuoi appartamenti</h5>

  <div class="row">
    @foreach ($sponsors as $sponsor)
    <div class="col">
      <div class="card text-white p-3 border-0" style="background-image: linear-gradient(to left,{{$sponsor->color}})">
        <div class="card-body">
          <h5 class="card-title">{{$sponsor->label}}</h5>
          <h6 class="card-subtitle mb-2 text-body-secondary">{{$sponsor->description}}</h6>
          <p class="card-text">{{$sponsor->price}}€ per {{$sponsor->duration}}/h</p>
          <a href="" class="btn ">Passa a pro</a>
        </div>
      </div>
    </div>
  @endforeach
  </div>
        

@endsection