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
        <th scope="col" class="d-flex justify-content-end">
          <a href="{{route('admin.apartments.create')}}" class="btn btn-success">Aggiungi appartamento <i class="fa-solid fa-house-medical"></i></a>
        </th>
      </tr>
    </thead>
    <tbody>
      @forelse ($apartments as $apartment)
      <tr>
        <td><img src="{{$apartment->cover}}" alt="{{$apartment->title}}" class="img-fluid table-img rounded-1"></td>
        <td>{{$apartment->title}}</td>
        <td>{{$apartment->is_visible}}</td>
        <td>{{$apartment->created_at}}</td>
        <td>{{$apartment->updated_at}}</td>
        <td>
          <div class="d-flex justify-content-end align-items-center gap-1">
            <a href="{{route('admin.apartments.show', $apartment->id)}}" class="btn btn-sm btn-primary"><i class="fa-regular fa-eye"></i></a>
            <a href="{{route('admin.apartments.edit', $apartment->id)}}" class="btn btn-sm btn-warning"><i class="fa-regular fa-pen-to-square"></i></a>
            <form method="POST" action="{{route('admin.apartments.destroy', $apartment->id)}}">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-danger"><i class="fa-regular fa-trash-can"></i></button>
            </form>
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