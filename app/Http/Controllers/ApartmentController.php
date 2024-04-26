<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Http\Requests\UpdateApartmentRequest;
use App\Http\Requests\StoreApartmentRequest;
use App\Models\Message;
use App\Models\Service;
use App\Models\Sponsor;
use App\Models\View;
use Braintree\Gateway;
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

    public function drop(Apartment $apartment)
    {

        /* ELIMINAZIONE DEFINITIVA DI UN RECORD */
        $apartment->forceDelete();


        /* RESTITUISCO IN PAGINA */
        return to_route('admin.apartments.trash')
            ->with('type', 'danger')
            ->with('message', "Hai eliminato '$apartment->title' definitivamente.");
    }


    // Svuota completamente il cestino
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


    // Ripristina completamente il cestino
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



    // Sponsor
    // public function sponsor(Apartment $apartment)
    // {

    //     // Check if authorized
    //     if (Auth::id() !== $apartment->user_id) {
    //         return to_route('admin.apartments.index', $apartment)->with('alert-type', 'warning')->with('alert-message', 'Non sei autorizzato!');
    //     }

    //     // Setup Braintree
    //     $gateway = new \Braintree\Gateway(config('braintree'));
    //     $clientToken = $gateway->clientToken()->generate();


    //     // Get all sponsors
    //     $sponsors = Sponsor::all();

    //     return view('admin.apartments.sponsor', compact('apartment', 'sponsors', 'clientToken'));
    // }
    public function sponsor(Apartment $apartment)
    {
        // Verifica se autorizzato
        if (Auth::id() !== $apartment->user_id) {
            return redirect()->route('admin.apartments.index')->with('alert-type', 'warning')->with('alert-message', 'Non sei autorizzato!');
        }

        // Inizializza Braintree Gateway con le credenziali
        $gateway = new Gateway([
            'environment' => config('braintree.environment'),
            'merchantId' => config('braintree.merchantId'),
            'publicKey' => config('braintree.publicKey'),
            'privateKey' => config('braintree.privateKey')
        ]);

        // Genera il token di autorizzazione Braintree
        $clientToken = $gateway->clientToken()->generate();

        // Recupera tutti gli sponsor
        $sponsors = Sponsor::all();

        return view('admin.apartments.sponsor', compact('apartment', 'sponsors', 'clientToken'));
    }

    // ...

    public function sponsorize(Request $request, String $id)
    {

        // Get apartment with end date data
        $apartment = Apartment::withMax(['sponsors' => function ($query) {
            $query->where('apartment_sponsor.end_date', '>=', date("Y-m-d H:i:s"));
        }], 'apartment_sponsor.end_date')->find($id);

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
            $start_date = $apartment->sponsors_max_apartment_sponsored_date ?? date('Y-m-d H:i:s'); // start promotion from active promotion or now
            $end_date = date('Y-m-d H:i:s', strtotime("+ $sponsor->duration hours", strtotime($start_date))); // end prootion based on start date and sponsor chosen

            // Set pivot table fields
            $apartment->sponsors()->attach($data['sponsor'], ['start_date' => $start_date, 'end_date' => $end_date]);

            return to_route('admin.apartments.index')->with('alert-message', "Promozione $sponsor->name attivata sul boolbnb $apartment->title. Totale pagato: $sponsor->price €.")->with('alert-type', 'success');
        }

        // Payment failed
        return to_route('admin.apartments.index')->with('alert-message', "Il pagamento non è andato a buon fine.")->with('alert-type', 'danger');
    }
}
