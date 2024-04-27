{{-- MODALE MAPPA --}}
<div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
    <div class="map modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            {{-- SE CE UN INDIRIZZO --}}
            @if ($apartment->address)
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="map modal-body flex-column flex-lg-row">
                    {{-- TTITOLO E INDIRIZZO --}}
                    <div class="description ">
                        <h3>{{ $apartment->title }}</h3>
                        <hr>
                        <h5>Si trova a </h5>
                        <h6>{{ $apartment->address }}</h6>
                    </div>
                    {{-- MAPPA --}}
                    <div>
                        <div id="map" data-latitude="{{ $apartment->latitude }}"
                            data-longitude="{{ $apartment->longitude }}">
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>