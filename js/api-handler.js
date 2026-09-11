/**
 * Fetches current weather data for Friedberg (Hessen) from Open-Meteo API
 * and updates DOM elements with live values and update timestamps.
 */
function fetchWeatherData() {
    // Geo-coordinates for Friedberg (Hessen)
    const latitude = 50.3350;
    const longitude = 8.7547;
    const apiUrl = `https://api.open-meteo.com/v1/forecast?latitude=${latitude}&longitude=${longitude}&current_weather=true`;

    fetch(apiUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error('Netzwerkantwort war nicht erfolgreich');
            }
            return response.json();
        })
        .then(data => {
    const currentWeather = data.current_weather;

    // DOM Elements
    const locationEl = document.getElementById('weatherLocation');
    const tempEl = document.getElementById('weatherTemperature');
    const windEl = document.getElementById('weatherWind');
    const timeEl = document.getElementById('weatherLastUpdated');
    const nextUpdateEl = document.getElementById('weatherNextUpdate');

    // Values
    if (locationEl) locationEl.innerText = 'Wetter in Friedberg (Hessen)';
    if (tempEl) tempEl.innerText = `${currentWeather.temperature} °C`;
    if (windEl) windEl.innerText = `Windgeschwindigkeit: ${currentWeather.windspeed} km/h`;

    // Time Formatting
    if (currentWeather.time) {
        const apiTime = new Date(currentWeather.time);
        const formattedTime = apiTime.toLocaleTimeString('de-DE', { hour: '2-digit', minute: '2-digit' });

        const nextUpdateTime = new Date(apiTime);
        nextUpdateTime.setHours(nextUpdateTime.getHours() + 1);
        const formattedNextTime = nextUpdateTime.toLocaleTimeString('de-DE', { hour: '2-digit', minute: '2-digit' });

        if (timeEl) timeEl.innerText = `Letztes API-Update: ${formattedTime} Uhr`;
        if (nextUpdateEl) nextUpdateEl.innerText = `Nächstes reguläres Update: ca. ${formattedNextTime} Uhr (stündlich)`;
    }
})
        .catch(error => {
            console.error('API Fetch Error:', error);
            const locationEl = document.getElementById('weatherLocation');
            if (locationEl) {
                locationEl.innerText = 'Fehler beim Laden der Wetterdaten.';
            }
        });
}

// Event listener once DOM content is fully loaded
document.addEventListener('DOMContentLoaded', function () {
    fetchWeatherData();

    const refreshButton = document.getElementById('refreshApiBtn');
    if (refreshButton) {
        refreshButton.addEventListener('click', fetchWeatherData);
    }
});