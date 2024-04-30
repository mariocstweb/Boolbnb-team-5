@extends('layouts.app')

@section('title', 'Statistiche')

@section('content')

    {{-- NAVIGAZIONE PAGINE --}}
    <nav class="mt-4">
        <ol class="breadcrumb">
            <li><span><i class="fa-solid fa-chevron-left me-2 fs-5 mt-1"></i></span></li>
            <li class="breadcrumb-item"><a class="color-link" href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                Statistiche
            </li>
        </ol>
    </nav>
    <h1 class="mb-5">Statistiche dell'appartamento</h1>
    <div class="row mb-5 row-gap-3">
        <h2>Visualizzazioni</h2>
        <div class="col-6">
            {{-- CARD VISUALIZZAZZIONI MENSILI --}}
            <div class="card p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Visualizzazioni Mensili</h4>
                    <span class="btn bg-icon me-2"><i class="fa-regular fa-eye"></i></span>
                </div>
                <div class="box-grafic">
                    <canvas id="month-views"></canvas>
                </div>
            </div>
        </div>
        <div class="col-6">
            {{-- CARD VISUALIZZAZZIONI ANNUALE --}}
            <div class="card p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Visualizzazioni Annuali</h4>
                    <span class="btn bg-icon me-2"><i class="fa-regular fa-eye"></i></span>
                    
                </div>
                <div class="box-grafic">
                    <canvas id="year-views"></canvas>
                </div>
                
            </div>
        </div>
        <h2 class="mt-5">Messaggi</h2>
        <div class="col-6">
            {{-- CARD MESSAGGI MENSILI --}}
            <div class="card p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Messaggi Mensili</h4>
                    <span class="btn bg-icon me-2"><i class="fa-solid fa-envelope-open-text"></i></span>
                </div>
                <div class="box-grafic">
                    <canvas id="month-messages"></canvas>
                </div>
            </div>
        </div>
        <div class="col-6">
            {{-- CARD MESSAGGI ANNUALI --}}
            <div class="card p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Messaggi Annuali</h4>
                    <span class="btn bg-icon me-2"><i class="fa-solid fa-envelope-open-text"></i></span>
                </div>
                <div class="box-grafic">
                    <canvas id="year-messages"></canvas>
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
          const yearsAxis = ['2020', '2021', '2022', '2023'];
  
          // Get DOM Elems
          const viewsPerMonthsElem = document.getElementById('month-views');
          const viewsPerYearsElem = document.getElementById('year-views');
          const messagesPerMonthsElem = document.getElementById('month-messages');
          const messagesPerYearsElem = document.getElementById('year-messages');
  
          // Get Data From PHP
          const viewsPerMonthsData = <?php echo json_encode($month_views) ?>;
          const viewsPerYearsData = <?php echo json_encode($year_views) ?>;
          const messagesPerMonthsData = <?php echo json_encode($month_messages) ?>;
          const messagesPerYearsData = <?php echo json_encode($year_messages) ?>;
  
  
          //*** LOGIC ***//
          // Calculate values based on years axis
          const viewsPerYearsValues = yearsAxis.map(year => viewsPerYearsData[year] || 0);
          const messagesPerYearsValues = yearsAxis.map(year => messagesPerYearsData[year] || 0);
  
          // Init All Views Graphs
          initGraph(viewsPerMonthsElem, 'Visualizzazioni per mese', monthsAxis, Object.values(viewsPerMonthsData), '#dc3545');
          initGraph(viewsPerYearsElem, 'Visualizzazioni per anno', yearsAxis, viewsPerYearsValues, '#dc3545');
  
          // Init All Messages Graphs
          initGraph(messagesPerMonthsElem, 'Messaggi per mese', monthsAxis, Object.values(messagesPerMonthsData));
          initGraph(messagesPerYearsElem, 'Messaggi per anno', yearsAxis, messagesPerYearsValues);
      </script>
@endsection
