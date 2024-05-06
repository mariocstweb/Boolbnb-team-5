@extends('layouts.app')

@section('title', 'Messages')

@section('content')

    <div class="container my-5">

        <div class="card p-3 shadow">
            {{-- TITOLO --}}
            <h2>Lista Messaggi</h2>

            {{-- TABELLA --}}
            <table class="table table-white table-hover align-middle mt-5">
    
                {{-- HEADER TABELLA --}}
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Titolo</th>
                        <th scope="col">Contenuto</th>
                        <th scope="col">Email</th>
                        <th scope="col">Appartamento</th>
                        <th scope="col" class="d-none d-lg-table-cell">Data</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
    
                {{-- BODY TABELLA --}}
                <tbody>
                    @forelse ($messages as $message)
                        <tr>
                            {{-- ID --}}
                            <th scope="row">{{ $message->id }}</th>
    
                            {{-- TITOLO--}}
                            <td>{{ $message->name }}</td>
    
                            {{-- CONTENUTO --}}
                            <td>{{ $message->text }}</td>
    
                            {{-- EMAIL --}}
                            <td>{{ $message->email }}</td>
    
                            {{-- APPARATEMNTO CORRISPONDENTE --}}
                            <td>{{ $message->apartment_id }}</td>
    
                            {{-- DATA MESSAGGIO RICEVUTO --}}
                            <td class="d-none d-lg-table-cell">{{ $message->getDate('created_at') }}</td>
                        </tr>
    
                        {{-- ALTRIMENTI --}}
                    @empty
                        <tr>
                            <td class="text-center" colspan="8">
                                <h3>Non ci sono messaggi</h3>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

@endsection