{{-- MODALE
<div class="modal fade" id="payment" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="payment-title fs-5" >Ciaoooooo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="payment-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                <button type="button" class="btn btn-info" id="modal-confirmation-button">Conferma</button>
            </div>
        </div>
    </div>
</div> --}}

<!-- Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Selezione il tuo sponsor</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <ul>
            @foreach ($sponsors as $sponsor)
              <li>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="radio-{{$sponsor->id}}" id="sponsor-{{ $sponsor->id }}" value="{{ $sponsor->id }}"
                  @if ($loop->first) checked @endif>
                  <label class="form-check-label" for="radio-{{$sponsor->id}}">
                    <span class="me-2" style="background-image: linear-gradient(to left,{{ $sponsor->color }});-webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-weight: 700;">{{$sponsor->label}}</span> €{{$sponsor->price}} / {{$sponsor->duration}}h
                  </label>
                </div>      
              </li>
            @endforeach
          </ul>

          <div id="dropin-container"></div>
            <input type="submit" class="btn bg-hover" value="Ordina e Paga" />
            <input type="hidden" id="nonce" name="payment_method_nonce" />
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

