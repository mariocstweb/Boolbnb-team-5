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
                    <span>{{ $apartments->total() }}</span>
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
            {{-- CARD VISUALIZZAZZIONI TOTALI--}}
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
      <!--Import cdn ChartJS-->
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <script>
          //*** FUNCTIONS ***//
  
          /**
           * Inizialize a Chart JS Graph
           */
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
  
  
          //*** INIT ***//
          // Axis Data
          const monthsAxis = ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre',
              'Ottobre', 'Novembre', 'Dicembre'
          ];
          const yearsAxis = ['2021', '2022', '2023', '2024'];
  
          // Get DOM Elems
          const viewsTotalElem = document.getElementById('total-views');
          const messagesTotalElem = document.getElementById('total-messages');
         
  
          // Get Data From PHP
          const viewsTotalData = <?php echo json_encode($month_views) ?>;
          const messagesTotalData = <?php echo json_encode($month_messages) ?>;
        
          // Init All Views Graphs
          initGraph(viewsTotalElem, 'Visualizzazioni totali', monthsAxis, object.values(viewsTotalData), '#dc3545');
         
  
          // Init All Messages Graphs
          
          initGraph(messagesTotalElem, 'Messaggi totali', monthsAxis,  object.values(messagesTotalData));
      </script>
@endsection
