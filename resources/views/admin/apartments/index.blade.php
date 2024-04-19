@extends('layouts.app')

@section('title', 'Appartamenti')

@section('content')
{{-- Barra di ricerca --}}
<div class="row d-flex justify-content-center align-items-center mt-5">
  <div class="col-6">
      <form method="GET" action="{{ route('admin.apartments.index')}}">
          <div class="d-flex search">
              <input type="search" class="form-control border-0 search me-2 " placeholder=" Cerca..." name="search"
              value="{{ $search }}">
              <button class="btn text-white search-button bg-base-color" type="submit"><i class="fa-solid fa-magnifying-glass rounded-circle"></i></button>
          </div>
      </form>
  </div>
</div>
<div class="d-flex justify-content-between align-items-center my-4">
  <h3 class="mb-0">I tuoi appartamenti</h3>


  <div>
    {{-- Aggiungi appartamento --}}
    <a href="{{route('admin.apartments.create')}}" class="btn btn-light bg-base-color me-2 rounded-4 text-white">Aggiungi appartamento <i class="fa-solid fa-house-medical ms-1"></i></a>

    {{-- Cestino --}}
    <a class="btn btn-light border round-50" href="{{route('admin.apartments.trash')}}"><i class="fa-regular fa-trash-can"></i></a>  
  </div>
</div>

@if($apartments->count() > 0)
  {{-- Tabella appartamenti --}}
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
          <td>{!!$apartment->is_visible ? '<i class="fa-solid fa-circle-check text-success"></i>' : '<i class="fa-solid fa-circle-xmark text-danger"></i>'!!}</td>

          {{-- Creazione --}}
          <td>{{$apartment->created_at}}</td>

          {{-- Modifica --}}
          <td>{{$apartment->updated_at}}</td>
          <td>
            <div class="d-flex justify-content-end align-items-center gap-1">

              {{-- Show appartamento --}}
              <a href="{{route('admin.apartments.show', $apartment->id)}}" class="btn btn-sm bg-base-color border border-light text-white round-50 d-flex align-items-center justify-content-center"><i class="fa-regular fa-eye"></i></a>
              <div>

                {{-- Dropdown --}}
                <button type="button" class="btn btn-light dropdown-toggle round-50 border" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fa-solid fa-gear"></i>  
                </button>
                <ul class="dropdown-menu p-2">
                  <li>

                    {{-- Form modifica --}}
                    <a href="{{route('admin.apartments.edit', $apartment->id)}}" class="dropdown-item bg-warning text-white rounded-3 mb-2 text-center"><i class="fa-regular fa-pen-to-square"></i> Modifica</a>
                  </li>
                  <li>

                    {{-- Form cancellazione soft --}}
                    <form method="POST" action="{{route('admin.apartments.destroy', $apartment->id)}}">
                      @csrf
                      @method('DELETE')
                      <button class="bg-danger text-white w-100 border-0 rounded-3 p-1"><i class="fa-regular fa-trash-can"></i> Cestina</button>
                    </form>
                  </li>
                </ul>
              </div>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@else
  <h2 class=" text-center">Non ci sono appartamenti registrati</h2>
@endif
@endsection