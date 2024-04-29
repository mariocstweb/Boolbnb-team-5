<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Http\Requests\UpdateApartmentRequest;
use App\Http\Requests\StoreApartmentRequest;
use App\Models\Message;
use App\Models\Service;
use App\Models\Sponsor;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        /* RECUPERO VALORE DEL NAME DELL'INPUT DI RICERCA */
        $search = $request->query('search');


        /* INIZZIALIZZO LA QUERY CHE FILTRA GLI APPARTAMENTI IN BASE ALL'ID DELL'UTENTE AUTENTICATO */
        $query = Apartment::where('user_id', Auth::id());


        /* SE NEL CAMPO INPUT DI RICERCA E' INSERITO QUALCOSA */
        if ($search) {

            /* FILTRO LA QUERY IN BASE AL VALORE DELLA VARIBILE(NAME) */
            $query->where('title', 'LIKE', "$search%");
        }


        /* ORDINO I RISULTATI DELLA QUERY IN ORDINE */
        $query->orderByDesc('updated_at')->orderByDesc('created_at');


        /* PAGINAZIONE */
        $apartments = $query->paginate(3);


        /* RECUEPRO TUTTI I RECORD DALLA TABELLA SPONSOR */
        $sponsors = Sponsor::all();


        /* RESTITUISCO IN PAGINA */
        return view('admin.apartments.index', compact('apartments', 'search', 'sponsors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        /* RECUEPRO TUTTI I RECORD DALLA TABELLA SERVIZI */
        $services = Service::all();


        /* INIZZIALIZZO UN ARRAY VUOTO IN MODO DA NON DARMI ERRORE NEL FORM */
        $array_services = array();


        /* CREO UNA NUOVA INSTAZZA IN MODO DA NON DARMI ERRORE NEL FORM */
        $apartment = new Apartment;


        /* RESTITUISCO IN PAGINA */
        return view('admin.apartments.create', compact('apartment', 'services', 'array_services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApartmentRequest $request)
    {

        /* INFORMAZIONI SUI DATI DI VALIDAZIONE */
        $data = $request->validated();


        /* CREO UNA NUOVA INSTAZZA DALLA CLASSE APARTAMENT */
        $apartment = new Apartment();


        /* POPOLO L'OGGETTO CON I VALORI DELL'ARRAY DATA */
        $apartment->fill($data);


        /* CONTROLLO SE NELL'ARRAY DATA ESTISTE LA CHIAVE 'IS_VISIBLE' */
        $apartment->is_visible = array_key_exists('is_visible', $data);


        /* ASSEGNO LL'APARTAMENTO ID DELL'UTENTE  AUTENTICATO PER INDICARE CHE GLI APPARTIENE */
        $apartment->user_id = Auth::id();


        /* SALVO INFORMAZIONI */
        $apartment->save();


        /* VERIFICO SE ESISTE NELL'ARRAY LA CHIAVE SERVICES, SE ESTISTE */
        if (Arr::exists($data, 'services')) {

            /* ATTACCO I RECORD DELL'APPARTAMENTO AI RECORD DELI SERVIZI */
            $apartment->services()->attach($data['services']);
        }


        /* RESTITUISCO IN PAGINA */
        return to_route('admin.apartments.show', $apartment->id)
            ->with('message', 'Hai inserito correttamente un nuovo appartamento')
            ->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {

        /* SE ID DELL'UTENTE AUTENTICATO NON E' IDENTICO ALL'ID DELL'UTENTE PROPRIETARIO DELL'APPARTAMENTO */
        if (Auth::id() !== $apartment->user_id) {

            /* RESTITUISCO UN MESSAGGIO */
            return to_route('admin.apartments.index')->with('type', 'warning')->with('message', 'Non sei autorizzato!');
        }


        /* RECUEPRO TUTTI I RECORD DALLA TABELLA SERVIZI */
        $services = Service::all();


        /* RECUEPRO TUTTI I RECORD DALLA TABELLA VISSUALIZZAZIONI */
        $views = View::all();


        /* RECUEPRO TUTTI I RECORD DALLA TABELLA MESSAGGI */
        $messages = Message::all();


        /* RECUEPRO TUTTI I RECORD DALLA TABELLA SPONSOR */
        $sponsors = Sponsor::all();


        /* RESTITUISCO IN PAGINA */
        return view('admin.apartments.show', compact('apartment', 'services', 'views', 'messages', 'sponsors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {
        /* SE ID DELL'UTENTE AUTENTICATO NON E' IDENTICO ALL'ID DELL'UTENTE PROPRIETARIO DELL'APPARTAMENTO */
        if (Auth::id() !== $apartment->user_id) {

            /* RESTITUISCO UN MESSAGGIO */
            return to_route('admin.apartments.index')->with('type', 'warning')->with('message', 'Non sei autorizzato!');
        }

        /* CREO ARRAY CON GLI ID DI SERVICES */
        $array_services = $apartment->services->pluck('id')->toArray();


        /* RECUEPRO TUTTI I RECORD DALLA TABELLA SERVIZI */
        $services = Service::all();


        /* RESTITUSCO IN PAGINA */
        return view('admin.apartments.edit', compact('apartment', 'services', 'array_services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {

        /* INFORMAZIONI SUI DATI DI VALIDAZIONE */
        $data = $request->validated();


        /* POPOLO L'OGGETTO CON I VALORI DELL'ARRAY DATA */
        $apartment->fill($data);


        /* CONTROLLO SE NELL'ARRAY DATA ESTISTE LA CHIAVE 'IS_VISIBLE' */
        $apartment->is_visible = array_key_exists('is_visible', $data);


        /* AGGIORNO INFORMAZIONI */
        $apartment->update($data);


        /* VERIFICO SE ESISTE NELL'ARRAY LA CHIAVE SERVICES, SE ESTISTE */
        if (Arr::exists($data, 'services')) {

            /* SINCRONIZZO I RECORD DELL'APPARTAMENTO AI RECORD DEI SERVIZI*/
            $apartment->services()->sync($data['services']);

            /*  ALTRIMENTI SE NON ESISTE E HA UNA RELAZIONE CHIAMATA 'SERVICES' */
        } elseif (!Arr::exists($data, 'services') && $apartment->has('services')) {

            /* DISSOCIA I RECORD DELL'APPARTAMENTO AI RECORD DEI SERVIZI */
            $apartment->services()->detach($data['services']);
        }


        /* RESTITUISCO IN PAGINA */
        return to_route('admin.apartments.show', $apartment->id)
            ->with('type', 'warning')
            ->with('message', "'$apartment->title' modificato con successo.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {

        /* ELIMINAZIONE SOFT */
        $apartment->delete();


        /* RESTITUISCO IN PAGINA */
        return to_route('admin.apartments.index')
            ->with('type', 'danger')
            ->with('message', "Hai spostato '$apartment->title' nel cestino.");
    }

    /* CESTINO */
    public function trash()
    {

        /* RECUPERO I RECORD ELIMINATI MA NON DEFINITIVAMENTE */
        $apartments = Apartment::onlyTrashed()->get();


        /* RESTITUISCO IN PAGINA */
        return view('admin.apartments.trash', compact('apartments'));
    }

    public function restore(Apartment $apartment)
    {

        /* RIPRISTONO UN RECORD */
        $apartment->restore();


        /* RESTITUISCO IN PAGINA */
        return to_route('admin.apartments.index')
            ->with('type', 'success')
            ->with('message', "Hai ripristinato '$apartment->title' con successo.");
    }

    /* ELIMINAZIONE DEFINITIVA CESTINO */
    public function drop(Apartment $apartment)
    {

        /* ELIMINAZIONE DEFINITIVA DI UN RECORD */
        $apartment->forceDelete();


        /* RESTITUISCO IN PAGINA */
        return to_route('admin.apartments.trash')
            ->with('type', 'danger')
            ->with('message', "Hai eliminato '$apartment->title' definitivamente.");
    }


    /* SVUOTA CAMPI CESTINO */
    public function empty()
    {

        /* RECUPERO I RECORD ELIMINATI MA NON DEFINITIVAMENTE */
        $apartments = Apartment::onlyTrashed()->get();


        /* CICLO SU OGNI ELEMENTO */
        foreach ($apartments as $apartment) {

            /* CANCELLAZZIONE DEI TITOLI ARCHIVIATI IN STORAGE */
            if ($apartment->title) {
                Storage::delete($apartment->title);
            }


            /* ELIMINAZIONE DI TUTTI I RECORD */
            $apartment->forceDelete();
        }


        /* RESTITUISCO IN PAGINA */
        return to_route('admin.apartments.trash')
            ->with('type', 'danger')
            ->with('message', "Cestino svuotato");
    }


    /* RIPRISTINA TUTTO DAL CESTINO */
    public function returned()
    {

        /* RECUPERO I RECORD ELIMINATI MA NON DEFINITIVAMENTE */
        $apartments = Apartment::onlyTrashed()->get();


        /* CICLO SU OGNI ELEMENTO */
        foreach ($apartments as $apartment) {

            /* RIPRISTONO TUTTI I RECORD */
            $apartment->restore();
        }


        /* RESTITUISCO IN PAGINA */
        return to_route('admin.apartments.index')
            ->with('type', 'info')
            ->with('message', "Hai ripristinato tutti gli appartamenti");
    }


    /* SPONSOR */
    public function sponsor(Apartment $apartment)
    {

        /* VERIFICO SE ID DELL'UTENTE ATTUALMENTE AUTENTICATO NON E' IDENTICO ALL'ID DELL'UTENTE DELL'APPARTAMENTO (PROPRIETARIO) */
        if (Auth::id() !== $apartment->user_id) {

            /* MESSAGGIO SE GLI ID NON CORRISPONDONO */
            return to_route('admin.apartments.index', $apartment)->with('type', 'warning')->with('message', 'Non sei autorizzato!');
        }


        /* CREO UNA NUOVA ISTANZA DI BRAINTREE GATEWAY E UTILIZZO LE CONFIGURAZZIONE DEL FILE CREATO IN CONFIG */
        $gateway = new \Braintree\Gateway(config('braintree'));


        /* GENERO UN TOKEN PER ESSERE UTILIZZATO PER INTERAGIRE IN MODO SICURO CON BRAINTREE PER I PAGAMENTI */
        $clientToken = $gateway->clientToken()->generate();


        /* RECUEPRO TUTTI I RECORD DALLA TABELLA SPONSOR */
        $sponsors = Sponsor::all();


        /* RESTITUISCO IN PAGINA */
        return view('admin.apartments.sponsor', compact('apartment', 'sponsors', 'clientToken'));
    }


    // /* SPONSORIZZAZIONE */
    // public function sponsorize(Request $request, $id)
    // {

    //     /* RECUPERO SPECIFICO APPARTAMENTO IN BASE AL SUO ID */
    //     $apartment = Apartment::findOrFail($id);


    //     /* RECUEPRO DATI INVIATI TRAMITE RICHIESTA E FACCIO LA VALIDAZIONE */
    //     $data = $request->validate([
    //         'sponsor' => 'required|exists:sponsors,id',
    //         'payment_method_nonce' => 'required',
    //     ]);

    //     /* RECUPERO SPECIFICO SPONSOR IN BASE AL SUO ID (RECUPERO DAI DATA) */
    //     $sponsor = Sponsor::findOrFail($data['sponsor']);


    //     /* CREO UNA NUOVA ISTANZA DI BRAINTREE GATEWAY E UTILIZZO LE CONFIGURAZZIONE DEL FILE CREATO IN CONFIG */
    //     $gateway = new \Braintree\Gateway(config('braintree'));

    //     /* TRANSIZIONE DI VENDITA */
    //     $result = $gateway->transaction()->sale([
    //         'amount' => $sponsor->price, // IMPORTO DA ADDEBITARE
    //         'paymentMethodNonce' => $data['payment_method_nonce'], // METODO DI PAGAMENTO
    //         'options' => [
    //             'submitForSettlement' => true // TRANSIZIONE INVITA PER LA LIQUIDAZIONE IMMEDIATA
    //         ]
    //     ]);


    //     /* CONTROLLO TRANSIZIONE E' STATA ESEGUITA CON SUCCESSO */
    //     if ($result->success) {


    //         /* CALCOLO DATA DI INIZIO DELLA SPOSORIZZAZIONE ????? */
    //         $startDate = $apartment->sponsors_max_apartment_sponsorend_date ?? now();
    //         $expiration_date = now()->addHours($sponsor->duration);


    //         /* ATTACCO I RECORD DEGLI APPARTAMNETI AGLI SPONSOR */
    //         $apartment->sponsors()->attach($sponsor, ['start_date' => $startDate, 'expiration_date' => $expiration_date]);


    //         /* RESTITUISCO IN PAGINA */
    //         return redirect()->route('admin.apartments.index')
    //             ->with('message', "La sponsorizzazione '$sponsor->label' è stata attivata con successo per l'appartamento '$apartment->title'.")
    //             ->with('type', 'success');


    //         /* ALTRIMENNTI */
    //     } else {


    //         /* MESSAGGIO DI ERRORE */
    //         $errorMessage = $result->message;


    //         /* RESTITUISCO IN PAGINA */
    //         return redirect()->route('admin.apartments.index')
    //             ->with('message', "Errore durante il pagamento: $errorMessage")
    //             ->with('type', 'danger');
    //     }
    // }

    public function sponsorize(Request $request, String $id)
    {

        // Get apartment with end date data
        $apartment = Apartment::withMax(['sponsors' => function ($query) {
            $query->where('apartment_sponsor.expiration_date', '>=', date("Y-m-d H:i:s"));
        }], 'apartment_sponsor.expiration_date')->find($id);


        // Check if apartment already has an active sponsor
        if ($apartment->sponsors()->where('expiration_date', '>=', now())->exists()) {
            return to_route('admin.apartments.index')->with('message', "L'appartamento ha già un abbonamento attivo.")->with('type', 'danger');
        }

        // Get all request inputs
        $data = $request->all();

        // Get Promotion Chosen Data
        $sponsor = Sponsor::find($data['sponsor']);


        // Make transaction
        $gateway = new \Braintree\Gateway(config('braintree'));

        $payment = $gateway->transaction()->sale([
            'amount' => $sponsor->price,
            'paymentMethodNonce' => $data['payment_method_nonce'],
            'options' => [
                'submitForSettlement' => True
            ]
        ]);


        // Payment success
        if ($payment->success) {

            // Calculate pivot table fields data
            $start_date = $apartment->promotions_max_apartment_promotionend_date ?? date('Y-m-d H:i:s'); // start promotion from active promotion or now
            $expiration_date = date('Y-m-d H:i:s', strtotime("+ $sponsor->duration hours", strtotime($start_date))); // end prootion based on start date and promotion chosen

            // Set pivot table fields
            // $apartment->sponsors()->attach($data['sponsor'], ['start_date' => $start_date, 'expiration_date' => $expiration_date]);

            $apartment->sponsors()->attach($sponsor->id, ['start_date' => $start_date, 'expiration_date' => $expiration_date]);


            return to_route('admin.apartments.index')->with('message', "Promozione $sponsor->label attivata sul boolbnb $apartment->title. Totale pagato: $sponsor->price €.")->with('type', 'success');
        }

        // Payment failed
        return to_route('admin.apartments.index')->with('message', "Il pagamento non è andato a buon fine.")->with('type', 'danger');
    }
}
