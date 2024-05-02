@extends('layouts.app')

@section('title', 'Appartamenti')

@section('content')

    {{-- NAVIGAZIONE PAGINE --}}
    <nav class="mt-4">
        <ol class="breadcrumb">
            <li><span><i class="fa-solid fa-chevron-left me-2 fs-5 mt-1"></i></span></li>
            <li class="breadcrumb-item"><a class="color-link" href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                Appartamenti
            </li>
        </ol>
    </nav>
    <h1 class="mb-5">I tuoi appartamenti</h1>
    <div class="d-flex justify-content-between align-items-center mb-5">
        {{-- BARRA DI RICERCA --}}
        <form method="GET" action="{{ route('admin.apartments.index') }}">
            <div class="d-flex border p-1 rounded w-search">
                <input type="search" class="form-control border-0 me-2" placeholder="Cerca un appartamento" name="search"
                    value="{{ $search }}">
                <button class="btn btn-sm text-white bg-hover px-2" type="submit"><i
                        class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
        <div>
            {{-- AGGIUNGI APPARTAMENTO --}}
            <a href="{{ route('admin.apartments.create') }}" class="btn bg-hover me-2 text-white p-2"><i
                    class="fa-solid fa-house-medical ms-1"></i> Aggiungi appartamento</a>
            {{-- VAI AL CESTINO --}}
            <a class="btn c-main p-2 bg-hover-rev" href="{{ route('admin.apartments.trash') }}"><i
                    class="fa-regular fa-trash-can"></i> Cestino</a>
        </div>
    </div>
    {{-- SE IL CONTEGGIO DEGLI APPARTAMENTI E' MAGGIORE DI 0 --}}
    @if ($apartments->count() > 0)
        {{-- TABELLA APPARTAMENTI --}}
        <table class="table table-hover">
            <thead class="border-top">
                <tr>
                    <th scope="col">Anteprima</th>
                    <th scope="col">ID</th>
                    <th scope="col">Nome Appartamento</th>
                    <th scope="col">Pubblicato</th>
                    <th scope="col">Sponsorizzazione</th>
                    <th scope="col">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($apartments as $apartment)
                    <tr>

                        {{-- COVER --}}
                        <td><img src="{{ $apartment->cover }}" alt="{{ $apartment->title }}"
                                class="img-fluid table-img rounded-1"></td>

                        {{-- ID --}}
                        <td>{{ $apartment->id }}</td>

                        {{-- TITOLO  --}}
                        <td>{{ $apartment->title }}</td>

                        {{-- STATO --}}
                        <td class="text-start fs-4">{!! $apartment->is_visible
                            ? '<i class="fa-solid fa-circle-check text-success"></i>'
                            : '<i class="fa-solid fa-circle-xmark text-danger"></i>' !!}</td>

                        {{-- SPONSORIZZAZZIONE --}}
                        <td>
                            {{-- CICLO CHE HA COME CONDIZIONE DI VERIFICARE SE GLI SPONSOR SONO ASSOCIATIO AGLI APPARTAMENTI --}}
                            @forelse ($apartment->sponsors as $sponsor)
                                <div class="badge-sponsor text-center d-flex align-items-center gap-2 justify-content-center"
                                    style="background-image: linear-gradient(to left,{{ $sponsor->premium }})">
                                    <i class="fa-solid fa-award"></i> Premium</div>
                            {{-- ALTRIMENTI --}}
                            @empty
                                <a href="{{ route('admin.apartments.sponsor', $apartment->id) }}"
                                    class="btn bg-hover text-white p-2">Sponsorizza</a>
                            @endforelse
                        </td>
                        
                        {{-- AZIONI --}}
                        <td>
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    {{-- CESTINO (ELIMINA) --}}
                                    <form method="POST" action="{{ route('admin.apartments.destroy', $apartment->id) }}"
                                        data-bs-toggle="modal" data-bs-target="#modal"
                                        data-apartment="{{ $apartment->title }}" class="del-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn bg-icon"><i
                                                class="fa-regular fa-trash-can"></i></button>
                                    </form>
                                    {{-- MODIFICA --}}
                                    <a href="{{ route('admin.apartments.edit', $apartment->id) }}" class="btn bg-icon"><i
                                            class="fa-regular fa-pen-to-square"></i></a>
                                </div>
                                {{-- VAI AL DETTAGLIO --}}
                                <a href="{{ route('admin.apartments.show', $apartment->id) }}" class="btn"><i
                                        class="fa-solid fa-chevron-right"></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- PAGINAZIONE --}}
        <div class="row">
            <div class="col-4">
                <p class="text-start">{{ $apartments->firstItem() }} - {{ $apartments->lastItem() }} di
                    {{ $apartments->total() }} risultati</p>
            </div>
            <div class="col-4 d-flex justify-content-center">
                {{ $apartments->links('pagination::bootstrap-4', ['prev_page_url' => 'Precedente', 'next_page_url' => 'Successivo']) }}
            </div>
        </div>
        {{-- ALTRIMENTI --}}
    @else
        <h2 class=" text-center">Non ci sono appartamenti registrati</h2>
    @endif
@endsection

@section('scripts')
    {{-- MODALE --}}
    @vite('resources/js/delete_confirmation.js')
@endsection
