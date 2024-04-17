@extends('layouts.app')

@section('title', 'Appartamenti')

@section('content')
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Immagine</th>
        <th scope="col">Titolo</th>
        <th scope="col">Stato</th>
        <th scope="col">Creato il:</th>
        <th scope="col">Modificato il:</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($apartments as $apartment)
      <tr>
        <td><img src="{{$apartment->cover}}" alt="{{$apartment->title}}" class="img-fluid"></td>
        <td>{{$apartment->title}}</td>
        <td>{{$apartment->is_visible}}</td>
        <td>{{$apartment->created_at}}</td>
        <td>{{$apartment->updated_at}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
@endsection