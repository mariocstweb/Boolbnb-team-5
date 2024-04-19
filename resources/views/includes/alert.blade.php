{{-- Alert di conferma eliminazione progetto --}}
@session('message')
<div class="alert alert-{{session('type', 'info')}} alert-dismissible fade show mt-3" role="alert">
  {{$value}}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endsession

{{--Alert Errori--}}
@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show my-5">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif