@extends('layouts.app')

@section('content')

<h1 class="mt-5 mb-5">Pannello di controllo</h1>


<div class="row mb-5">
    <div class="col">
        <div class="card p-3">
            <h3>Appartamenti in gestione</h3>
            <div>
                <span class="btn bg-icon me-2"><i class="fa-solid fa-house"></i></span>
                <span>{{$apartments->total()}}</span>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card p-3">
        <h3>Messaggi totali</h3>
        <div>
            <span class="btn bg-icon me-2"><i class="fa-solid fa-envelope-open-text"></i></span>
            <span>{{$messages->count()}}</span>
        </div>

    </div>
</div>
    <div class="col">
        <div class="card p-3">
            <h3>Visualizzazioni totali</h3>
            <div>
                <span class="btn bg-icon me-2"><i class="fa-regular fa-eye"></i></span>
                <span>{{$views->count()}}</span>
            </div>
        </div>
    </div>
</div>
  
  @if($apartments->count() > 0)
    {{-- Tabella appartamenti --}}
    <table class="table table-hover">
      <thead class="border-top">
        <tr>
          <th scope="col">Anteprima</th>
          <th scope="col">ID</th>
          <th scope="col">Nome Appartamento</th>
          <th scope="col">Visualizzazioni</th>
          <th scope="col">Messaggi</th>
          <th scope="col">Azioni</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($apartments as $apartment)
          <tr>
  
            {{-- Cover --}}
            <td><img src="{{$apartment->cover}}" alt="{{$apartment->title}}" class="img-fluid table-img rounded-1"></td>
  
            {{-- ID --}}
            <td>{{$apartment->id}}</td>
  
            {{-- Titolo --}}
            <td>{{$apartment->title}}</td>
  
            {{-- Visualizzazioni --}}
            <td>
              <span class="me-2"><i class="fa-regular fa-eye"></i></span> {{$apartment->viewsCount()}}
            </td>

            {{-- Messaggi --}}
            <td>
              <span class="me-2"><i class="fa-solid fa-envelope-open-text"></i></span> {{$apartment->messagesCount()}}
            </td>
  
            {{-- Dettaglio --}}
            <td>
              <div class="d-flex justify-content-between">
                    {{-- Statistiche --}}
                <a href="{{route('admin.statistic', $apartment->id)}}" class="btn bg-icon"><i class="fa-solid fa-chart-line"></i></a>
                <div class="d-flex align-items-center justify-content-center">
                {{-- Dettaglio --}}
                <a href="{{route('admin.apartments.show', $apartment->id)}}" class="btn"><i class="fa-solid fa-chevron-right"></i></a>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="row">
     <div class="col-4"><p class="text-start">{{ $apartments->firstItem() }} - {{ $apartments->lastItem() }} di {{ $apartments->total() }} risultati</p></div>
      <div class="col-4 d-flex justify-content-center">
      {{ $apartments->links('pagination::bootstrap-4', ['prev_page_url' => 'Precedente', 'next_page_url' => 'Successivo']) }}
      </div>
    </div>
  @else
    <h2 class=" text-center">Non ci sono appartamenti registrati</h2>
  @endif
  @endsection
  
  @section('scripts')
    @vite('resources/js/delete_confirmation.js')
@endsection
