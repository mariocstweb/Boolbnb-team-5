@extends('layouts.app')

@section('title', 'Statistiche')

@section('content')

    {{-- NAVIGAZIONE PAGINE --}}
    <nav class="mt-4">
        <ol class="breadcrumb">
            <li><span><i class="fa-solid fa-chevron-left me-2 fs-5 mt-1"></i></span></li>
            <li class="breadcrumb-item"><a class="color-link" href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                Statistiche
            </li>
        </ol>
    </nav>
    <h1 class="mb-5">Statistiche dell'appartamento</h1>
    <div class="row mb-5 row-gap-3">
        <h2>Visualizzazioni</h2>
        <div class="col-6">
            {{-- CARD VISUALIZZAZZIONI MENSILI --}}
            <div class="card p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Visualizzazioni Mensili</h4>
                    <span class="btn bg-icon me-2"><i class="fa-regular fa-eye"></i></span>
                </div>
            </div>
        </div>
        <div class="col-6">
            {{-- CARD VISUALIZZAZZIONI ANNUALE --}}
            <div class="card p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Visualizzazioni Annuali</h4>
                    <span class="btn bg-icon me-2"><i class="fa-regular fa-eye"></i></span>
                </div>
            </div>
        </div>
        <h2 class="mt-5">Messaggi</h2>
        <div class="col-6">
            {{-- CARD MESSAGGI MENSILI --}}
            <div class="card p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Messaggi Mensili</h4>
                    <span class="btn bg-icon me-2"><i class="fa-solid fa-envelope-open-text"></i></span>
                </div>
            </div>
        </div>
        <div class="col-6">
            {{-- CARD MESSAGGI ANNUALI --}}
            <div class="card p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Messaggi Annuali</h4>
                    <span class="btn bg-icon me-2"><i class="fa-solid fa-envelope-open-text"></i></span>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    {{-- JS GRAFICI --}}
    @vite('resources/js/grafic.js')
@endsection
