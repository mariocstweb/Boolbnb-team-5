@extends('layouts.app')

@section('title', 'Appartamenti')

@section('content')

<div class="d-flex justify-content-between align-items-center my-4">
  <h3 class="mb-0">I tuoi appartamenti</h3>

  <div>
    <a href="{{route('admin.apartments.create')}}" class="btn btn-light bg-base-color me-2 rounded-4 text-white">Aggiungi appartamento <i class="fa-solid fa-house-medical ms-1"></i></a>
    <a class="btn btn-light border round-50" href=""><i class="fa-regular fa-trash-can"></i></a>  
  </div>
</div>

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
      @forelse ($apartments as $apartment)
        <tr>
          <td class="text-start"><img src="{{$apartment->cover}}" alt="{{$apartment->title}}" class="img-fluid table-img rounded-1"></td>
          <td>{{$apartment->title}}</td>
          <td>{{$apartment->is_visible}}</td>
          <td>{{$apartment->created_at}}</td>
          <td>{{$apartment->updated_at}}</td>
          <td>
            <div class="d-flex justify-content-end align-items-center gap-1">
              <a href="{{route('admin.apartments.show', $apartment->id)}}" class="btn btn-sm btn-primary round-50 d-flex align-items-center justify-content-center"><i class="fa-regular fa-eye"></i></a>
              <div>
                <button type="button" class="btn btn-light dropdown-toggle round-50 border" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fa-solid fa-gear"></i>  
                </button>
                <ul class="dropdown-menu p-2">
                  <li>
                    <a href="{{route('admin.apartments.edit', $apartment->id)}}" class="dropdown-item bg-warning text-white rounded-3 mb-2 text-center"><i class="fa-regular fa-pen-to-square"></i> Modifica</a>
                  </li>
                  <li>
                    <form method="POST" action="{{route('admin.apartments.destroy', $apartment->id)}}">
                      @csrf
                      @method('DELETE')
                      <button class="bg-danger text-white w-100 border-0 rounded-3 p-1"><i class="fa-regular fa-trash-can"></i> Elimina</button>
                    </form>
                  </li>
                </ul>
              </div>
              {{-- <a href="{{route('admin.apartments.show', $apartment->id)}}" class="btn btn-sm btn-primary"><i class="fa-regular fa-eye"></i></a>
              <a href="{{route('admin.apartments.edit', $apartment->id)}}" class="btn btn-sm btn-warning"><i class="fa-regular fa-pen-to-square"></i></a>
              <form method="POST" action="{{route('admin.apartments.destroy', $apartment->id)}}">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger"><i class="fa-regular fa-trash-can"></i></button>
              </form> --}}
            </div>
          </td>
        </tr>
      @empty
      <tr>
        <td colspan="6"></td>
      </tr>
      @endforelse
    </tbody>
  </table>
@endsection