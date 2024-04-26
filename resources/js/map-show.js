/* -----------------------------------------
* MAP VIEWER
-------------------------------------------*/
import tt from "@tomtom-international/web-sdk-maps"

// INIT
const mapButton = document.getElementById('map-button');
const mapContainer = document.getElementById('map');

// Funzione per gestire il click sul pulsante della mappa
function handleMapButtonClick() {
    if (mapContainer) {


        const lat = mapContainer.dataset.latitude;
        const lon = mapContainer.dataset.longitude;

        const map = tt.map({
            key: import.meta.env.VITE_TT_API_KEY,
            container: mapContainer,
            center: [
                lon,
                lat
            ],
            zoom: 12
        });
        map.addControl(new tt.NavigationControl());

        const marker = new tt.Marker().setLngLat([lon, lat]).addTo(map);

        // Fix map size bug
        setTimeout(() => { map.resize(); }, 200);

        // Rimuove l'event listener dopo aver creato la mappa
        mapButton.removeEventListener('click', handleMapButtonClick);
    }
}

// Aggiunge l'event listener per il click sul pulsante della mappa
mapButton.addEventListener('click', handleMapButtonClick);
