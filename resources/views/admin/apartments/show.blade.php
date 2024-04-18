@extends('layouts.app')

@section('title', 'Appartamento')

@section('content')
  <h1 class="text-center my-5">{{$apartment->title}}</h1>
  <hr>
  <div class="d-flex justify-content-center">
    
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
  </div>
@endsection