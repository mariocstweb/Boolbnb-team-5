@extends('layouts.app')

@section('title', 'Appartamenti')

@section('content')

<div class="d-flex justify-content-between align-items-center my-4">
  <h3 class="mb-0">Cestino</h3>

<div class="d-flex justify-content-end align-items-center gap-2">
  {{-- Ripristina tutto --}}
  <form action="{{route('admin.apartments.returned')}}" method="POST">
    @csrf
    @method('PATCH')
    <button type="submit" class="btn btn-success rounded-4"><i class="fa-solid fa-rotate"></i> Ripristina tutto</button>
  </form>

  {{-- Svuota il cestino --}}
  <form action="{{ route('admin.apartments.empty') }}" method="POST">
  @csrf
  @method('DELETE')
  <button type="submit" class="btn btn-danger rounded-4">
      <i class="fa-solid fa-trash-can-arrow-up me-2"></i>Svuota Cestino
  </button>
</form>
</div>
</div>

  {{-- Tabella appartamenti --}}
  @if($apartments->count() > 0)
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col" class="text-start">Anteprima</th>
          <th scope="col">Titolo</th>
          <th scope="col">Stato</th>
          <th scope="col">Data Creazione</th>
          <th scope="col">Ultima Midifica</th>
          <th scope="col">
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach ($apartments as $apartment)
          <tr>
  
            {{-- Cover --}}
            <td class="text-start"><img src="{{$apartment->cover}}" alt="{{$apartment->title}}" class="img-fluid table-img rounded-1"></td>
  
            {{-- Titolo --}}
            <td>{{$apartment->title}}</td>
  
            {{-- Stato --}}
            <td>{{$apartment->is_visible}}</td>
  
            {{-- Creazione --}}
            <td>{{$apartment->created_at}}</td>
  
            {{-- Modifica --}}
            <td>{{$apartment->updated_at}}</td>
            <td>
              <div class="d-flex justify-content-end align-items-center gap-1">
                          {{--# RESTORE --}}
                    <form action="{{route('admin.apartments.restore', $apartment->id)}}" method="POST">
                      @csrf
                      @method('PATCH')
                      <button type="submit" class="btn btn-success round-50"><i class="fa-solid fa-rotate"></i></button>
                    </form>
  
                      {{-- Form cancellazione --}}
                      <form method="POST" action="{{route('admin.apartments.drop', $apartment->id)}}" data-bs-toggle="modal" data-bs-target="#modal" data-apartment="{{ $apartment->title }}" class="del-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger round-50"><i class="fa-regular fa-trash-can"></i> </button>
                      </form>
                </div>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <h2 class=" text-center">Cestino vuoto</h2>
  @endif


  <a class="btn btn-secondary" href="{{route('admin.apartments.index')}}">Torna alla Home</a>
@endsection

@section('scripts')
  @vite('resources/js/delete_confirmation.js')
@endsection