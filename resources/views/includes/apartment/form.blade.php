@if ($apartment->exists)
    <form action="{{ route('admin.apartments.update', $apartment) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
    @else
        <form action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data">
@endif


@csrf

<div class="row my-5">
    <div class="col-6">
        <div class="mb-3">
            <label for="title" class="form-label">Nome Appartamento <i class="fa-solid fa-house"></i></label>
            <input type="text"
                class="form-control @error('title') is-invalid
              @elseif (old('title', '')) is-valid 
            @enderror"
                id="title" name="title" value="{{ old('title', $apartment->title) }}">
            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="address" class="form-label">Indirizzo <i class="fa-solid fa-location-dot"></i></label>
            <input type="text"
                class="form-control @error('address') is-invalid
              @elseif (old('address', '')) is-valid 
            @enderror"
                id="address" name="address" value="{{ old('address', $apartment->address) }}">
            @error('address')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="mb-3">
            <label for="latitude" class="form-label">Latitudine <i class="fa-solid fa-house"></i></label>
            <input type="text"
                class="form-control @error('latitude') is-invalid
              @elseif (old('latitude', '')) is-valid 
            @enderror"
                id="latitude" name="latitude" value="{{ old('latitude', $apartment->latitude) }}">
            @error('latitude')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="longitude" class="form-label">Longitudine <i class="fa-solid fa-location-dot"></i></label>
            <input type="text"
                class="form-control @error('longitude') is-invalid
              @elseif (old('longitude', '')) is-valid 
            @enderror"
                id="longitude" name="longitude" value="{{ old('longitude', $apartment->longitude) }}">
            @error('longitude')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    {{-- <div class="col-12">
        <div class="mb-3">
            <label for="description" class="form-label">Descrizione</label>
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
    </div> --}}

    <div class="col-3">
        <div class="mb-3">
            <label for="rooms" class="form-label">Camere <i class="fa-solid fa-door-closed"></i></label>
            <input type="number"
                class="form-control @error('rooms') is-invalid
              @elseif (old('rooms', '')) is-valid 
            @enderror"
                id="rooms" name="rooms" value="{{ old('rooms', $apartment->rooms) }}">
            @error('rooms')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="col-3">
        <div class="mb-3">
            <label for="beds" class="form-label">Letti <i class="fa-solid fa-bed"></i></label>
            <input type="number"
                class="form-control @error('beds') is-invalid
              @elseif (old('beds', '')) is-valid 
            @enderror"
                id="beds" name="beds" value="{{ old('beds', $apartment->beds) }}">
            @error('beds')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="col-3">
        <div class="mb-3">
            <label for="bathrooms" class="form-label">Bagni <i class="fa-solid fa-bath"></i></label>
            <input type="number"
                class="form-control @error('bathrooms') is-invalid
              @elseif (old('bathrooms', '')) is-valid 
            @enderror"
                id="bathrooms" name="bathrooms" value="{{ old('bathrooms', $apartment->bathrooms) }}">
            @error('bathrooms')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="col-3">
        <div class="mb-3">
            <label for="sqm" class="form-label">Metri Quadrati <i class="fa-solid fa-ruler-combined"></i></label>
            <input type="number"
                class="form-control @error('sqm') is-invalid
              @elseif (old('sqm', '')) is-valid 
            @enderror"
                id="sqm" name="sqm" value="{{ old('sqm', $apartment->sqm) }}">
            @error('sqm')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    
    <div class="col-11">
        <div class="my-3">
            <label for="cover" class="form-label">Immagine</label>
            <div @class(['form-control', 'd-flex', 'd-none' => !$apartment->cover])  id='previous-image-field'>
                
                <button class="btn btn-outline-secondary w-25 me-1" type="button" id="change-image-button">Cambia
                    Immagine</button>
                <input type="text" class="form-control" value="{{ old('cover', $apartment->cover) }}" disabled>  
            </div>
            <input type="file"
                class="form-control @if ($apartment->cover) d-none @endif @error('cover') is-invalid @elseif (old('cover', '')) is-valid @enderror"
                name='cover' id="cover">
        </div>
        @error('cover')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div class="form-text">Carica un file immagine</div>
        @enderror
    </div>
    <div class="col-1 d-flex justify-content-center align-items-center">
        <div>
            <img src="{{ old('cover', $apartment->cover) ? $apartment->cover : 'https://marcolanci.it/boolean/assets/placeholder.png' }}"
                class="img-fluid" alt="{{ $apartment->cover ? $apartment->title : 'preview' }}" id='preview'>
        </div>
    </div>

    <div class="col-2 mt-5">
        <div class="form-check form-switch">
            <input value="1" type="checkbox" class="form-check-input" id="is_visible" name="is_visible" role="button"
                @if (old('is_visible', $apartment->is_visible)) checked @endif>
            <label for="is_visible" class="form-check-label">Pubblica</label>
        </div>
    </div>


</div>
<div class="d-flex align-items-center justify-content-between">
    <a href="{{ route('admin.apartments.index') }}" class="btn btn-primary"><i class="fa-solid fa-arrow-left me-2"></i>Torna
        indietro</a>
    <div class="align-items-center d-flex gap-2">
        <button class="btn btn-secondary" type="reset"><i class="fa-solid fa-eraser me-2"></i>Svuota i campi</button>
        <button class="btn btn-success" type="submit"><i class="fa-solid fa-floppy-disk me-2"></i>Salva</button>

    </div>
</div>
</form>
