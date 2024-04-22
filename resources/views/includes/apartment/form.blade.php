@if ($apartment->exists)
    {{-- SALVATAGGIO MODIFICHE --}}
    <form action="{{ route('admin.apartments.update', $apartment) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
    @else
        {{-- SALVATAGGIO DI CREAZIONE --}}
        <form action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data">
@endif
@csrf
{{-- LISTA LINK --}}
<div class="d-flex align-items-center justify-content-between mt-4">
    <nav class="mt-3">
        <ol class="breadcrumb">
            <li><span><i class="fa-solid fa-chevron-left me-2 fs-5 mt-1"></i></span></li>
            <li class="breadcrumb-item"><a class="color-link" href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a class="color-link" href="{{ route('admin.apartments.index') }}">Appartamenti</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ $apartment->exists ? 'Modifica appartamento' : 'Aggiungi appartamento' }}
            </li>
        </ol>
    </nav>
    {{-- BOTTONE SALVA --}}
    <button class="btn bg-hover text-white" type="submit"><i class="fa-solid fa-floppy-disk me-2"></i>Salva</button>
</div>
{{-- CONTENUTO FORM --}}
<div class="d-flex gap-5 mt-3 mb-5">
    <div class="row w-100">
        <div class="card">
            <h2 class="mt-4">Info appartamento</h2>
            <div class="d-flex gap-4 mt-3">
                {{-- NOME APPARTAMENTO --}}
                <div class="col-5">
                    <div class="mb-3">
                        <label for="title" class="form-label"> Nome Appartamento <span
                                class="form-text text-danger">*</span></label>
                                <div class="input-container">
                                    <input type="text"
                                        class="form-control @error('title') is-invalid @elseif (old('title', '')) is-valid @enderror"
                                        id="title" name="title" value="{{ old('title', $apartment->title) }}">
                                    @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @else
                                        <i class="fa-solid fa-house-chimney icon"></i>
                                    @enderror
                                </div>
                    </div>
                </div>
                {{-- INDIRIZZO --}}
                <div class="col-5">
                    <label for="address-search" class="form-label"> Indirizzo <span
                            class="form-text text-danger">*</span></label>
                    <div class="d-block card-data">
                        <div class="input-container">
                            <input id="search-address" name="address" autocomplete="off"
                                value="{{ old('address', $apartment->address) }}" type="text"
                                class="form-control @error('address') is-invalid @enderror">
                            @error('address')
                                <span class="invalid-feedback error-message" role="alert">{{ $message }}</span>
                                @else
                                <i class="fa-solid fa-location-dot icon"></i>
                            @enderror
                            <ul id="suggestions" class="suggestions-list"></ul>
                        </div>
                        <span id="address-error" class="text-danger error-message"></span>
                        <input type="hidden" name="latitude" id="latitude"
                            value="{{ old('latitude', $apartment->latitude) }}">
                        <input type="hidden" name="longitude" id="longitude"
                            value="{{ old('longitude', $apartment->longitude) }}">
                    </div>
                </div>
            </div>
            <h2 class="mt-4">Dettagli appartamento</h2>
            <div class="d-flex gap-4 mt-3">
                {{-- CAMERE --}}
                <div class="col-4">
                    <div class="mb-3">
                        <label for="rooms" class="form-label">Camere <span
                            class="form-text text-danger">*</span></label>
                        <div class="input-container">
                            <input type="number"
                                class="form-control @error('rooms') is-invalid @elseif (old('rooms', '')) is-valid @enderror"
                                id="rooms" name="rooms" value="{{ old('rooms', $apartment->rooms) }}">
                                @error('rooms')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @else
                                <i class="fa-solid fa-door-open icon"></i>
                                @enderror
                            </div>
                    </div>
                </div>
                {{-- LETTI --}}
                <div class="col-4">
                    <div class="mb-3">
                        <label for="beds" class="form-label">Letti <span
                            class="form-text text-danger">*</span></label>
                        <div class="input-container">
                            <input type="number"
                                class="form-control @error('beds') is-invalid
                            @elseif (old('beds', '')) is-valid 
                            @enderror"
                                id="beds" name="beds" value="{{ old('beds', $apartment->beds) }}">
                            @error('beds')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @else
                                <i class="fa-solid fa-bed icon"></i>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-4 mt-3">
                {{-- BAGNI --}}
                <div class="col-4">
                    <div class="mb-3">
                        <label for="bathrooms" class="form-label">Bagni <span
                            class="form-text text-danger">*</span></label>
                        <div class="input-container">
                            <input type="number"
                                class="form-control @error('bathrooms') is-invalid
                            @elseif (old('bathrooms', '')) is-valid 
                            @enderror"
                                id="bathrooms" name="bathrooms" value="{{ old('bathrooms', $apartment->bathrooms) }}">
                            @error('bathrooms')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @else
                                <i class="fa-solid fa-bath icon"></i>
                            @enderror
                        </div>
                    </div>
                </div>
                {{-- METRI QUADRI --}}
                <div class="col-4">
                    <div class="mb-3">
                        <label for="sqm" class="form-label">Metri Quadrati <span
                            class="form-text text-danger">*</span></label>
                        <div class="input-container">
                            <input type="number"
                                class="form-control @error('sqm') is-invalid
                            @elseif (old('sqm', '')) is-valid 
                            @enderror"
                                id="sqm" name="sqm" value="{{ old('sqm', $apartment->sqm) }}">
                            @error('sqm')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @else
                                <i class="fa-solid fa-ruler-horizontal icon"></i>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            {{-- IMMAGINE --}}
            <h2 class="mt-4">Media</h2>
            <div class="col-9">
                <div class="mt-3">
                    <label for="cover" class="form-label">Immagine </label>
                    {{-- BOTTONE CAMBIA IMMAGINE --}}
                    <div @class(['d-none' => !$apartment->cover]) id='previous-image-field'>
                        <div class="input-group mb-3">
                            <button class="btn btn-outline-secondary" type="button" id="change-image-button">Cambia
                                Immagine</button>
                            <input type="text" class="form-control" value="{{ old('cover', $apartment->cover) }}"
                                disabled>
                        </div>
                    </div>
                    {{-- BOTTONE CARICA FILE --}}
                    <input type="file"
                        class="form-control @if ($apartment->cover) d-none @endif @error('cover') is-invalid @elseif (old('cover', '')) is-valid @enderror"
                        name='cover' id="cover">
                </div>
                @error('cover')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            {{-- PREVIEW IMMAGINE --}}
            <div class="col-3">
                <div class="mt-3">
                    <img src="{{ old('cover', $apartment->cover) ? $apartment->cover : 'https://marcolanci.it/boolean/assets/placeholder.png' }}"
                        class="img-fluid rounded-3" alt="{{ $apartment->cover ? $apartment->title : 'preview' }}"
                        id='preview'>
                </div>
            </div>
            {{-- SWITCH PUBBLICAZIONE --}}
            <div class="col-12 my-5">
                <div class="form-check form-switch">
                    <input value="1" type="checkbox" class="form-check-input" id="is_visible"
                        name="is_visible" role="button" @if (old('is_visible', $apartment->is_visible)) checked @endif>
                    <label for="is_visible" class="form-check-label">Pubblica</label>
                </div>
            </div>
        </div>
    </div>
    {{--  --}}
    <div class="row w-75">
        <div class="card">
            {{-- DESCRIZIONE APPARTAMENTO --}}
            <div class="col-12">
                <h2 class="mt-4">Descrizione appartamento</h2>
                <div class="mt-3">
                    <label for="description" class="form-label">Descrizione <span
                        class="form-text text-danger">*</span></label>
                    <textarea
                        class="form-control @error('description') is-invalid
                    @elseif (old('description', '')) is-valid 
                    @enderror"
                        id="description" name="description" rows="10">{{ old('description', $apartment->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            {{-- CHECKBOX SERVIZI --}}
            <div class="col-12">
                <h2 class="mt-4">Servizi appartamento</h2>
                <div class="form-check mt-3">
                    <input class="form-check-input rounded-5" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Default checkbox
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
