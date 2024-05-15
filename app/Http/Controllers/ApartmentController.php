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
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $apartments = $query->paginate(5);


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

        // if (Arr::exists($data, 'cover')) {
        //     $img_url = Storage::putFile('cover', $data['cover']);
        //     $apartment->cover = $img_url;
        // }

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
        // $messages = Message::whereName()->orderByDesc('created_at');
        $messages = $apartment->messages()
            ->orderByDesc('created_at')
            ->get();


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
        // Trova l'appartamento
        $apartment = Apartment::findOrFail($apartment->id);
        $apartment->is_visible = false;
        $apartment->save();
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


    /* SPONSORIZZAZZIONE DELL'APPARATAMENTO */
    public function sponsorize(Request $request, String $id)
    {

        /* RECUPERO L'APPARATAMENTO CON LO SPONSOR CON DATA PIU' TARDIVA DI SCADENZA */
        $apartment = Apartment::withMax(['sponsors' => function ($query) {

            /* FILTRO GLI APPARATEMNTI CHE ANNO LO SPONSOR ATTIVO E DATA DI SCADENZA */
            $query->where('apartment_sponsor.expiration_date', '>=', date("d-m-Y H:i:s"));
        }], 'apartment_sponsor.expiration_date')->find($id); // SELEZIONI IN BASE ALL'ID SPECIFICO


        /* RECUERO I DATI DELLA RICGIESTA */
        $data = $request->all();


        /* RECUEPRO LO PSONSOR SELEZIONATO */
        $sponsor = Sponsor::find($data['sponsor']);


        /* UTILIZZANDO L'OGETTO DI GETEWAY DI BRAINTREE UTILIZO LA LORO CONFIGURAZIONE */
        $gateway = new \Braintree\Gateway(config('braintree'));


        /* TRANSIZIONE DI PAGAMENTO ATTRAVERSO BRAINTREE */
        $payment = $gateway->transaction()->sale([
            'amount' => $sponsor->price, // PREZZO SPONSOR
            'paymentMethodNonce' => $data['payment_method_nonce'], // METODO DI PAGAMENTO
            'options' => [
                'submitForSettlement' => True // TRASIZIONE IMMEDIATA
            ]
        ]);


        /* SE IL PAGAMENTO E' RIUSCITO */
        if ($payment->success) {

            /* CONTROLLO SE L'APPARTAMENTO HA GIA' UNO SPONSOR */
            if ($apartment->sponsors()->where('expiration_date', '>=', now())->exists()) {

                /* CERCO LO SPONSOR ATTUALMENTE ATTIVO */
                $currentSponsor = $apartment->sponsors()->orderBy('expiration_date', 'desc')->first();

                /* CALCOLA LA DATA DELLE SPONSOR ED EVENTUALE AGGIORNAMENTO NEL CASO DI UNO NUOVO */
                $newExpirationDate = Carbon::parse($currentSponsor->pivot->expiration_date)->addHours($sponsor->duration);

                /* AGGIORNO ENTRY PIVOT DELLA RELAZIONE TRA APPARATEMNTO E SPONSOR E AGGIURNO LA DATA DI SCADENZA */
                $apartment->sponsors()->updateExistingPivot($currentSponsor->id, ['expiration_date' => $newExpirationDate]);


                /* ALTRIMENTI AGGIUNGI UN SPONSOR NUOVO */
            } else {


                /* DATA DI INZIO DELLA SPONSORIZZAZIONE */
                $start_date = now();


                /* CALCOLO DELLA DATA DI SCADENZA AGGIUNGENDO LA DATA DI INZIO */
                $expiration_date = $start_date->copy()->addHours($sponsor->duration);


                /* ATTACO ALLA TABELLA PONTE SIA LA DATA DI SCADENZA CHE QUELLA D'INIZIO */
                $apartment->sponsors()->attach($sponsor->id, ['start_date' => $start_date, 'expiration_date' => $expiration_date]);
            }


            /* RESTITUISCO MESSAGGIO DI SUCCESSO */
            return redirect()->route('admin.apartments.index')->with('message', "Promozione $sponsor->label attivata sul boolbnb $apartment->title. Totale pagato: $sponsor->price €.")->with('type', 'success');
        }


        /* RESTITUISCO MESSAGGIO DI ERRORE */
        return to_route('admin.apartments.index')->with('message', "Il pagamento non è andato a buon fine.")->with('type', 'danger');
    }


    /* FUNZIONE STATISTICHE */
    public function statistics(Apartment $apartment)
    {

        /* VERIFICO SE L'UTENTE E' AUTENTICATO ED PROPRETARIO DELL'APPARTAMENTO */
        if (Auth::id() !== $apartment->user_id) {

            /* MESSAGGIO DI NON AUTORIZZATO */
            return to_route('admin.apartments.index', $apartment)->with('type', 'warning')->with('message', 'Non sei autorizzato!');
        }


        /* ARRAY PER IL CONTEGGIO DI MESSAGGI E VISSUALIZZAZIONI PER MESE E ANNO */
        $month_views = array_fill(0, 12, 0);
        $month_messages = array_fill(0, 12, 0);
        $year_views = [];
        $year_messages = [];


        /* FILTRO I MESSAGGI E VISUSLIZZAZIONI DELL'ULTIMO ANNO */
        $current_year_views = $apartment->views->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 year')));
        $current_year_messages = $apartment->messages->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 year')));


        /* CALCOLO LE VISSUALIZZAZIONI PER MESE DELL'ULTIMO ANNO */
        foreach ($current_year_views as $view) {
            $month = date("m", strtotime($view->created_at));
            $month_views[$month - 1]++;
        }


        /* CALCOLO LE VISSUALIZZAZIONI TOTALI PER ANNO */
        foreach ($apartment->views as $view) {
            $year = date("Y", strtotime($view->created_at));
            if (isset($year_views[$year])) {
                $year_views[$year]++;
            } else {
                $year_views[$year] = 1;
            }
        }


        /* CALCOLO I MESSAGGI PER MESE DELL'ULTIMO ANNO */
        foreach ($current_year_messages as $message) {
            $month = date("m", strtotime($message->created_at));
            $month_messages[$month - 1]++;
        }


        /* CALCOLO I MESSAGI TOTALI PER ANNO */
        foreach ($apartment->messages as $message) {
            $year = date("Y", strtotime($message->created_at));
            if (isset($year_messages[$year])) {
                $year_messages[$year]++;
            } else {
                $year_messages[$year] = 1;
            }
        }


        /* RESTUTUISCO I DATI DELLE STATICHE */
        return view('admin.apartments.statistics', compact('month_views', 'apartment', 'year_views', 'month_messages', 'year_messages'));
    }
}
