@extends('layouts.app')

@section('title', 'Pannello di controllo')

@section('content')

    <h1 class="mt-5 mb-5">Pannello di controllo</h1>
    <div class="row mb-5">
        <div class="col">
            {{-- CARD APPARTAMENTI IN GESTIONE --}}
            <div class="card p-3">
                <h3>Appartamenti in gestione</h3>
                <div>
                    <span class="btn bg-icon me-2"><i class="fa-solid fa-house"></i></span>
                    {{-- TOTALE APPARTAMENTI --}}
                    <span>{{ $apartments->total() }}</span>
                </div>
            </div>
        </div>
        <div class="col">
            {{-- CARD MESSAGGI TOTALI --}}
            <div class="card p-3">
                <h3>Messaggi totali</h3>
                <div>
                    <span class="btn bg-icon me-2"><i class="fa-solid fa-envelope-open-text"></i></span>
                    {{-- TOTALE MESSAGGI --}}
                    {{-- <span>{{ $messages->count() }}</span> --}}
                    <span>{{ $totalMessages }}</span>
                </div>

            </div>
        </div>
        <div class="col">
            {{-- CARD VISUALIZZAZIONI TOTLAI --}}
            <div class="card p-3">
                <h3>Visualizzazioni totali</h3>
                <div>
                    <span class="btn bg-icon me-2"><i class="fa-regular fa-eye"></i></span>
                    {{-- TOTLAE VISUALIZZAZIONI --}}
                    <span>{{ $totalViews }}</span>
                </div>
            </div>
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
                    <th scope="col">Sponsorizzazione</th>
                    <th scope="col">Visualizzazioni</th>
                    <th scope="col">Messaggi</th>
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

                        {{-- TITOLO --}}
                        <td>{{ $apartment->title }}</td>

                        {{-- Sponsorizzazione --}}

                        <td>
                            @if($apartment->sponsors->isNotEmpty())
                                {{ $apartment->sponsors->first()->expiration_date->format('Y-m-d H:i:s') }}
                            @else
                            <i class="fa-solid fa-circle-xmark text-danger"></i>
                            @endif
                        </td>

                        {{-- TUTTE LE VISUALIZZAZIONI DI QUEL SINGOLO APPARTAMENTO --}}
                        <td>
                            <span class="me-2"><i class="fa-regular fa-eye"></i></span> {{ $apartment->viewsCount() }}
                        </td>

                        {{-- TUUTI I MESSAGGI DI QUEL SINGOLO APPARTAMENTO --}}
                        <td>
                            <span class="me-2"><i class="fa-solid fa-envelope-open-text"></i></span>
                            {{ $apartment->messagesCount() }}
                        </td>

                        {{-- AZIONI --}}
                        <td>
                            <div class="d-flex justify-content-between">
                                {{-- STATISTICHE --}}
                                <a href="{{ route('admin.apartments.statistics', $apartment->id) }}" class="btn bg-icon"><i
                                        class="fa-solid fa-chart-line"></i></a>
                                <div class="d-flex align-items-center justify-content-center">
                                    {{-- DETTAGLIO --}}
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
