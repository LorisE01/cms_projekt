<?php
/**
 * Template Name: API Unterseite
 * Description: Template fuer die API-Einbindung (Medieninformatik Projekt)
 */

get_header(); // Lädt die Standard-Navigation
?>

<main class="container my-5">
    <!-- Header-Bereich für das Theme-Layout -->
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h1 class="display-4">Live-Wetterdaten</h1>
            <p class="lead">Eingebunden über die Open-Meteo REST-API</p>
        </div>
    </div>

    <!-- Bootstrap Card für die API-Ausgabe -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <h4 class="card-title text-primary" id="weatherLocation">Lade Daten...</h4>
                    <div class="display-4 my-3 fw-bold" id="weatherTemperature">-- °C</div>
                    <p class="text-muted" id="weatherWind">Windgeschwindigkeit: -- km/h</p>
                    <button id="refreshApiBtn" class="btn btn-outline-primary mt-2">
                        Daten aktualisieren
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

<?php 
get_footer(); // Lädt den Footer inkl. verpflichtendem Demoseiten-Hinweis
?>