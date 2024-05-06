@extends('layouts.app')

@section('title', 'Promozione')

@section('content')

@section('cdns')
<script src=" https://js.braintreegateway.com/web/dropin/1.40.2/js/dropin.min.js "></script>
@endsection

    {{-- NAVIGAZIONE PAGINE --}}
    <nav class="mt-4">
        <ol class="breadcrumb">
            <li><span><i class="fa-solid fa-chevron-left me-2 fs-5 mt-1"></i></span></li>
            <li class="breadcrumb-item"><a class="color-link" href="{{ route('admin.apartments.index') }}">Appartamenti</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Promo
            </li>
        </ol>
    </nav>
    {{-- LOGO --}}
    <img src="{{ Vite::asset('resources/img/plus.png') }}" alt="" class="img-fluid mt-4">
    <h3 class="my-4">Acquista uno dei nostri pacchetti e ottieni dei vantaggi esclusivi sui tuoi appartamenti</h3>

    <section class="card p-4 rounded-4">
        <h5 class="mb-4">
            Sponsorizza il tuo appartamento. Con la sponsorizzazione ottieni visibilità immediata per il tuo appartamento. È perfetto se desideri aumentare rapidamente la visibilità del tuo annuncio.
        </h5>
        {{-- FROM DI PAGAMENTO --}}
    <form id="payment-form" action="{{ route('admin.apartments.sponsorize', $apartment) }}" method="post" data-token="{{ $clientToken }}">
        @csrf
        <div class="row">
            {{-- CICLO SU GLI SPONSOR --}}
            @foreach ($sponsors as $sponsor)
                <div class="col">
                    <div class="card text-white p-3 border-0 rounded-4"
                        style="background-image: linear-gradient(to left,{{ $sponsor->color }})">
                        <div class="card-body">
                            <h1 class="card-title mb-3">{{ $sponsor->label }}</h1>
                            <p class="card-subtitle mb-4 fs-4">{{ $sponsor->description }}</p>
                            <p class="card-text fs-4"><strong class="fs-1">{{ $sponsor->price }}€</strong> per
                                {{ $sponsor->duration }}/h</p>
                            <div class="bg-white rounded">
                                <button type="button" id="button-{{ $sponsor->id }}" data-bs-toggle="modal" data-bs-target="#paymentModal" class="btn w-100 fs-4 payment-btn"
                                    style="background-image: linear-gradient(to left,{{ $sponsor->color }});-webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-weight: 700;">Passa a pro
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <input type="hidden" name="sponsor" id="sponsor" value="{{$sponsor->id}}">
            {{-- MODALE PAGAMENTO --}}
            @include('sponsor.includes.payment')
        </div>
    </form>
    </section>


@endsection

@section('scripts')
    {{-- MODALE PAGAMENTO --}}
    @vite('resources/js/payment.js')
    {{-- MODALE CHECK RADIO --}}
    @vite('resources/js/check_payment.js')
@endsection