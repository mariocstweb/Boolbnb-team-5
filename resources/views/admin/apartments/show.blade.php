@extends('layouts.app')

@section('title', 'Appartamento')

@section('content')
  {{-- <h1 class="text-center my-5">{{$apartment->title}}</h1>
  <hr> --}}
  {{-- <div class="d-flex justify-content-center">
    
      <div class="row g-3">
        <div class="col-md-5">
          <img src="{{$apartment->cover}}" class="img-fluid" alt="">
        </div>
        <div class="col-md-7">
          <div class="card-body">
            <p class="card-text">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nostrum aliquid, sunt autem error cupiditate unde hic inventore repellat, accusamus eius blanditiis ipsa pariatur sint illum, quia in dolorem impedit debitis.
            Accusantium, iure. Eos expedita quae sapiente? Totam aut quam consequuntur, soluta, facere, debitis culpa expedita ipsum ducimus tempore in omnis. Ut, consequuntur earum dicta provident ullam nisi perspiciatis rem laborum.
            Magnam iure cum laudantium eos fugit, quaerat qui ipsa excepturi ipsum fugiat perspiciatis voluptas expedita animi aut accusantium quo nemo. Architecto corrupti praesentium ipsa dignissimos sit obcaecati quod at dicta!
            Temporibus fugiat eligendi commodi quaerat labore, placeat tempora perspiciatis soluta, beatae debitis assumenda unde reiciendis, est aperiam necessitatibus aspernatur amet fuga? Deserunt accusantium voluptate obcaecati mollitia consequuntur alias debitis vero.
            </p>
          </div>
        </div>
        <div class="col">
          <div class="card-info">
            <div class="row">
              <h2 class="my-1">Info</h2>
              <hr>
              <div class="col my-4 d-flex justify-content-around">
                <div><i class="fa-solid fa-door-closed"></i> Stanze: <strong>{{$apartment->rooms}}</strong></div>
                <div><i class="fa-solid fa-bed"></i> Letti: <strong>{{$apartment->beds}}</strong></div>
                <div><i class="fa-solid fa-bath"></i> Bagni: <strong>{{$apartment->bathrooms}}</strong></div>
                <div><i class="fa-solid fa-ruler-combined"></i> <strong>{{$apartment->sqm}}</strong> mq2</div>
                <div><i class="fa-solid fa-location-dot"></i> Indirizzo: <strong>{{$apartment->address}}</strong></div>
            </div>
          </div>
          <div class="row">
            <h2 class="my-1">Servizi</h2>
            <hr>
            <div class="col my-4 d-flex justify-content-around">
              <div><i class="fa-solid fa-wifi"></i> wi-fi: <strong>{{$apartment->rooms}}</strong></div>
              
            </div>
          </div>
          <div class="d-flex justify-content-end align-items-center gap-2 mt-3">
            <a href="{{route('admin.apartments.index')}}" class="btn btn-primary">Torna indietro</a>
            <a href="{{route('admin.apartments.edit', $apartment->id)}}" class="btn btn-warning"><i class="fa-regular fa-pen-to-square"></i> Modifica</a>
          </div>
      </div>
  </div> --}}

  <div class="row mt-5">
    <div class="col-8">
      <section id="detail">
        <div class="card p-4">

          {{-- Titolo appartamento --}}
          <h1 class="mb-4">{{$apartment->title}}</h1>

          {{-- Immagine di copertina --}}
          <div class="thumb-img">
            <img src="{{$apartment->cover}}" alt="{{$apartment->title}}" class="img-fluid">
          </div>
          <div class="card-body">

            {{-- Descrizione appartamento --}}
            <h2 class="card-title mb-3">Descrizione appartamento</h2>
            <p class="card-text">Lorem ipsum dolor sit amet consectetur. In imperdiet iaculis enim lorem. Nibh nulla vulputate cursus ligula mauris. Rhoncus sit arcu accumsan sed tempor. Ut orci egestas at tincidunt. Faucibus odio diam aliquam odio neque aliquet massa. Nulla mauris nisl diam sit fusce. Turpis rutrum urna leo semper donec fermentum.
              Tincidunt vel velit vulputate laoreet justo non hendrerit faucibus in pellentesque.

              {{-- Indirizzo --}}
              <div class="road fw-bold"><i class="fa-solid fa-location-dot me-2"></i>{{$apartment->address}}</div>
            </p>

            {{-- Dettaglio appartamento --}}
            <h2 class="card-title mt-5 mb-2">Dettaglio appartamento</h2>
            <div class="fw-medium stats mb-2">Come è composto</div>
            <ul class="d-flex gap-3">
              <li>
                <span class="badge fw-medium"><i class="fa-solid fa-door-closed me-2"></i> {{$apartment->rooms}} camere</span>
              </li>
              <li>
                <span class="badge fw-medium"><i class="fa-solid fa-bath me-2"></i> {{$apartment->bathrooms}} bagni</span>
              </li>
              <li>
                <span class="badge fw-medium"><i class="fa-solid fa-ruler-horizontal me-2"></i> {{$apartment->sqm}} mq</span>
              </li>
              <li>
                <span class="badge fw-medium"><i class="fa-solid fa-bed me-2"></i> {{$apartment->rooms}} letti</span>
              </li>
            </ul>

            {{-- Statistiche --}}
            <div class="fw-medium stats mt-4 mb-2">Statistiche</div>
            <ul class="d-flex gap-3">
              <li>
                <span class="badge fw-medium"><i class="fa-regular fa-eye me-2"></i> 4523 Visualizzazioni</span>
              </li>
              <li>
                <span class="badge fw-medium"><i class="fa-regular fa-envelope me-2"></i> 12 Messaggi</span>
              </li>
            </ul>

            {{-- Stato pubblicazione --}}
            <div class="mt-5 fs-5">{!!$apartment->is_visible ? '<i class="fa-solid fa-circle-check text-success me-2"></i> <span class="text-success fw-bold">Pubblicato</span>' : '<i class="fa-solid fa-circle-xmark text-danger"></i> <span class="text-danger fw-bold">Non pubblicato</span>'!!}</div>
          </div>
        </div>
      </section>
    </div>
    <div class="col-4">
      <section id="services">
        <div class="card p-3">
          <div class="card-body">
            <h2 class="card-title mb-4">Servizi appartamento</h2>
            <ul class="p-0 m-0">
              @foreach ($services as $service)
              @if ($apartment->services)
                  <h1>ciao</h1>
              @endif
              <li class="fw-medium mb-3"><img src="" alt="">{{$service->label}}</li>
              @endforeach
            </ul>
          </div>
        </div>
      </section>
    </div>
  </div>
@endsection