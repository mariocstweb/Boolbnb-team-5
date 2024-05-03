@extends('layouts.app')

@section('title', 'Pannello di controllo')

@section('content')

@extends('layouts.app')

@section('title', 'Pannello di controllo')

@section('content')

    <h1 class="mt-5 mb-5">Pannello di controllo</h1>
    <div class="row mb-5">
        <div class="col">
            {{-- CARD APPARTAMENTI IN GESTIONE --}}
            <div class="card p-3">
                <h3>Appartamenti in gestione</h3>
                <div>
                    <span class="btn bg-icon me-2"><i class="fa-solid fa-house"></i></span>
                    {{-- TOTALE APPARTAMENTI --}}
                    <span>{{ $apartments->count() }}</span>
                </div>
            </div>
        </div>
        <div class="col">
            {{-- CARD MESSAGGI TOTALI --}}
            <div class="card p-3">
                <h3>Messaggi totali</h3>
                <div>
                    <span class="btn bg-icon me-2"><i class="fa-solid fa-envelope-open-text"></i></span>
                    {{-- TOTALE MESSAGGI --}}
                    {{-- <span>{{ $messages->count() }}</span> --}}
                    <span>{{ $totalMessages }}</span>
                </div>
            </div>
        </div>
        <div class="col">
            {{-- CARD VISUALIZZAZIONI TOTALI --}}
            <div class="card p-3">
                <h3>Visualizzazioni totali</h3>
                <div>
                    <span class="btn bg-icon me-2"><i class="fa-regular fa-eye"></i></span>
                    {{-- TOTALE VISUALIZZAZIONI --}}
                    <span>{{ $totalViews }}</span>
                </div>
            </div>
        </div>
    </div>
    <h1 class="mb-5">Statistiche</h1>
    <div class="row">
        <div class="col-6">
            {{-- CARD VISUALIZZAZIONI TOTALI--}}
            <div class="card p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Visualizzazioni</h4>
                    <span class="btn bg-icon me-2"><i class="fa-regular fa-eye"></i></span>
                </div>
                <div class="box-grafic">
                    <canvas id="total-views"></canvas>
                </div>
            </div>
        </div>
        <div class="col-6">
            {{-- CARD MESSAGGI MENSILI --}}
            <div class="card p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Messaggi</h4>
                    <span class="btn bg-icon me-2"><i class="fa-solid fa-envelope-open-text"></i></span>
                </div>
                <div class="box-grafic">
                    <canvas id="total-messages"></canvas>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js/dist/Chart.min.js"></script>

<script>
    // Funzione per inizializzare un grafico Chart JS
    const initGraph = (elem, title, labels, data, backgroundColor) => {
        const graph = new Chart(elem, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: title,
                    data,
                    borderWidth: 1,
                    backgroundColor
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        return graph;
    }

    // Assegni le variabili per gli assi dei mesi e dei anni
    const monthsAxis = ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre',
        'Ottobre', 'Novembre', 'Dicembre'
    ];

    // Ottieni gli elementi DOM dei grafici
    const viewsTotalElem = document.getElementById('total-views');
    const messagesTotalElem = document.getElementById('total-messages');

    // Ottieni i dati delle visualizzazioni e dei messaggi
    const viewsTotalData = <?php echo json_encode($month_views) ?>;
    const messagesTotalData = <?php echo json_encode($month_messages) ?>;

    // Inizializza il grafico delle visualizzazioni totali
    initGraph(viewsTotalElem, 'Visualizzazioni totali', monthsAxis, viewsTotalData, '#dc3545');

    // Inizializza il grafico dei messaggi totali
    initGraph(messagesTotalElem, 'Messaggi totali', monthsAxis, messagesTotalData);
</script>

@endsection
