@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row g-5 justify-content-center">
        <div class="col-md-4 col-lg-4">
            <div class="card-neomorphic">
                <div class="card-header-neomorphic text-center">
                    <i class="fas fa-cloud-sun header-icon"></i>
                    <h2 class="card-title-neomorphic mt-3 mb-1">Peramalan Kejahatan</h2>
                    <p class="card-subtitle-neomorphic">Prediksi jumlah kasus untuk tahun mendatang.</p>
                </div>
                <div class="card-body-neomorphic">
                    <form id="forecastForm" action="{{ route('forecast.submit') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-4 form-group-neumorphic">
                            <label for="location-input" class="form-label-neumorphic">
                                <i class="fas fa-map-marked-alt icon-form me-2"></i> Pilih Lokasi
                            </label>
                            <div class="custom-dropdown">
                                <input type="hidden" name="location" id="location-input" required>
                                <div class="dropdown-header">
                                    <span class="dropdown-selected-value">-- Pilih Kepolisian Daerah --</span>
                                    <i class="fas fa-caret-down dropdown-arrow"></i>
                                </div>
                                <ul class="dropdown-list">
                                    <li data-value="" class="selected">-- Pilih Kepolisian Daerah --</li>
                                    @foreach($locations as $location)
                                        <li data-value="{{ $location }}">{{ $location }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn-neumorphic-primary">
                                <i class="fas fa-chart-line me-2"></i> Ramalkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-lg-8 d-flex align-items-center">
            <div id="result-panel" class="card-neomorphic p-5 w-100 min-vh-50 d-flex flex-column justify-content-center align-items-center">
                @if (session('error'))
                    <div class="alert alert-danger fade show alert-neumorphic text-center w-100" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    </div>
                @elseif (session('forecastData'))
                    <div class="result-content-container text-center w-100">
                        <i class="fas fa-chart-line text-primary mb-3" style="font-size: 4rem;"></i>
                        <h4 class="result-title-new">Hasil Peramalan</h4>
                        <p class="result-info-text">Perkiraan jumlah kasus di <strong>{{ session('forecastData')['lokasi'] }}</strong>:</p>
                        <div class="row justify-content-center mb-4">
                            @foreach(session('forecastData')['forecast_years'] as $index => $year)
                                <div class="col-6 col-md-3 mb-3">
                                    <div class="card-neomorphic p-3">
                                        <h5 class="chart-title-neumorphic">{{ $year }}</h5>
                                        <h4 class="text-primary mt-2">
                                            <strong>{{ number_format(session('forecastData')['forecasts'][$index], 0, ',', '.') }}</strong>
                                        </h4>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-5 w-100">
                            <canvas id="forecastChart"></canvas>
                        </div>
                    </div>
                @else
                    <i class="fas fa-arrow-left result-placeholder-icon mb-4"></i>
                    <h4 class="result-placeholder-text">Pilih lokasi di sisi kiri untuk melihat hasil peramalan.</h4>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    /* Mengambil variabel dari layout utama */
    :root {
        --bg-color: #F0F4F7;
        --surface-color: #E0E1DD;
        --card-color: #F8F9FB;
        --text-primary: #0D1B2A;
        --text-secondary: #4A4E69;
        --theme-primary: #1B263B;
        --theme-accent: #FFD700;
        --shadow-light: #FFFFFF;
        --shadow-dark: #AAB7C4;
    }

    body {
        font-family: 'Inter', sans-serif;
    }

    .card-neomorphic {
        background-color: var(--card-color);
        border-radius: 25px;
        box-shadow: 10px 10px 20px var(--shadow-dark), 
                    -10px -10px 20px var(--shadow-light);
        transition: all 0.5s ease-in-out;
    }
    .card-neomorphic:hover {
        box-shadow: 15px 15px 30px var(--shadow-dark), 
                    -15px -15px 30px var(--shadow-light);
    }
    .card-header-neomorphic {
        background-color: var(--theme-primary);
        color: var(--surface-color);
        padding: 40px;
        border-radius: 25px 25px 0 0;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .card-header-neomorphic::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0));
    }
    .header-icon {
        font-size: 3rem;
        color: var(--theme-accent);
        animation: rotateIn 1.5s cubic-bezier(0.25, 0.8, 0.25, 1);
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }
    .card-title-neomorphic {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 2rem;
        color: var(--surface-color);
        margin-bottom: 0.2rem;
    }
    .card-subtitle-neomorphic {
        font-weight: 400;
        opacity: 0.9;
        color: var(--surface-color);
        font-size: 0.9rem;
    }
    .card-body-neomorphic {
        padding: 30px;
    }

    .form-label-neumorphic {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 1rem;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
    }

    /* --- Gaya Dropdown Kustom --- */
    .custom-dropdown {
        position: relative;
        background-color: var(--card-color);
        border-radius: 14px;
        box-shadow: inset 5px 5px 10px var(--shadow-dark), 
                    inset -5px -5px 10px var(--shadow-light);
        transition: box-shadow 0.3s ease;
        cursor: pointer;
    }
    .custom-dropdown:focus-within {
        box-shadow: inset 2px 2px 5px var(--shadow-dark), 
                    inset -2px -2px 5px var(--shadow-light);
    }
    .dropdown-header {
        padding: 14px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: var(--text-primary);
        font-size: 1rem;
    }
    .dropdown-arrow {
        transition: transform 0.3s ease;
    }
    .custom-dropdown.open .dropdown-arrow {
        transform: rotate(180deg);
    }
    .dropdown-list {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        margin-top: 5px;
        background-color: var(--card-color);
        border-radius: 14px;
        box-shadow: 5px 5px 10px var(--shadow-dark), 
                    -5px -5px 10px var(--shadow-light);
        list-style: none;
        padding: 0;
        z-index: 10;
        max-height: 200px;
        overflow-y: auto;
        display: none;
    }
    .custom-dropdown.open .dropdown-list {
        display: block;
    }
    .dropdown-list li {
        padding: 12px 20px;
        transition: background-color 0.2s ease;
        cursor: pointer;
    }
    .dropdown-list li:hover,
    .dropdown-list li.selected {
        background-color: var(--theme-primary);
        color: var(--surface-color);
        border-radius: 14px;
    }

    /* Tombol Neumorphism */
    .btn-neumorphic-primary {
        background-color: var(--theme-primary);
        color: var(--theme-accent);
        border: none;
        padding: 16px 30px;
        font-size: 1.1rem;
        font-weight: 700;
        border-radius: 50px;
        transition: all 0.4s ease;
        box-shadow: 8px 8px 15px rgba(13, 27, 42, 0.2);
        letter-spacing: 1px;
    }
    .btn-neumorphic-primary:hover {
        transform: translateY(-5px);
        box-shadow: 12px 12px 25px rgba(13, 27, 42, 0.3);
        color: #fff;
    }
    .btn-neumorphic-primary:active {
        box-shadow: inset 4px 4px 10px rgba(0,0,0,0.2), inset -4px -4px 10px rgba(255,255,255,0.2);
        transform: translateY(0);
    }

    /* Panel Hasil */
    #result-panel {
        min-height: 400px;
        border: 2px dashed var(--border-color);
        color: var(--text-secondary);
        animation: fadeIn 0.8s ease-in-out;
    }
    .alert-neumorphic {
        background-color: var(--card-color);
        border: none;
        box-shadow: 5px 5px 10px var(--shadow-dark), 
                    -5px -5px 10px var(--shadow-light);
        color: var(--text-secondary);
        padding: 1.5rem;
    }
    .alert-neumorphic.alert-danger {
        background-color: #FEE2E2;
        color: #991B1B;
    }
    .result-content-container {
        width: 100%;
        animation: fadeInScale 1s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    .result-placeholder-icon {
        font-size: 3rem;
        color: var(--border-color);
        animation: fadein 1s ease-in-out;
    }
    .result-placeholder-text {
        font-weight: 500;
        color: var(--text-secondary);
        animation: fadein 1s ease-in-out;
    }
    .result-title-new {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        color: var(--theme-primary);
        margin-bottom: 0;
    }
    .result-info-text {
        color: var(--text-secondary);
        font-size: 1rem;
        margin-bottom: 1.5rem;
    }
    .result-prediction-new {
        font-size: 4rem;
        font-weight: 700;
        color: var(--theme-primary);
        margin-top: 1rem;
        text-shadow: 2px 2px 5px rgba(0,0,0,0.1);
    }
    .result-prediction-label {
        font-weight: 500;
        color: var(--text-secondary);
        font-size: 1.1rem;
    }
    
    /* Animasi */
    @keyframes fadeInScale {
        from { opacity: 0; transform: scale(0.9) translateY(20px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
    @keyframes rotateIn {
        from { transform: rotateY(90deg) scale(0.5); opacity: 0; }
        to { transform: rotateY(0deg) scale(1); opacity: 1; }
    }
    @keyframes loading-pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.7; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Skrip untuk dropdown kustom
        document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
            const header = dropdown.querySelector('.dropdown-header');
            const list = dropdown.querySelector('.dropdown-list');
            const hiddenInput = dropdown.querySelector('input[type="hidden"]');
            const selectedValueSpan = dropdown.querySelector('.dropdown-selected-value');

            header.addEventListener('click', () => {
                dropdown.classList.toggle('open');
            });

            list.querySelectorAll('li').forEach(item => {
                item.addEventListener('click', () => {
                    const value = item.getAttribute('data-value');
                    const text = item.textContent;
                    
                    hiddenInput.value = value;
                    selectedValueSpan.textContent = text;

                    list.querySelectorAll('li').forEach(li => li.classList.remove('selected'));
                    item.classList.add('selected');

                    dropdown.classList.remove('open');
                });
            });

            document.addEventListener('click', (event) => {
                if (!dropdown.contains(event.target)) {
                    dropdown.classList.remove('open');
                }
            });
        });

        // Skrip untuk Chart.js
        @if (session('forecastData'))
            const data = @json(session('forecastData'));
            const ctx = document.getElementById('forecastChart').getContext('2d');
            const existingChart = Chart.getChart(ctx);
            if (existingChart) {
                existingChart.destroy();
            }

            const historicalLabels = ['2021', '2022'];
            const historicalData = [data.data_2021, data.data_2022];
            
            const forecastLabels = data.forecast_years;
            const forecastData = data.forecasts;
            
            const labels = [...historicalLabels, ...forecastLabels];
            const allData = [...historicalData, ...forecastData];

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Jumlah Tindak Pidana',
                            data: allData,
                            backgroundColor: 'rgba(27, 38, 59, 0.7)',
                            borderColor: 'rgba(27, 38, 59, 1)',
                            pointBackgroundColor: 'rgba(27, 38, 59, 1)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: 'rgba(255, 215, 0, 1)',
                            pointHoverBorderColor: 'rgba(27, 38, 59, 1)',
                            fill: false,
                            tension: 0.4
                        },
                        {
                            label: 'Garis Peramalan',
                            data: [...Array(historicalData.length - 1).fill(null), historicalData[historicalData.length-1], ...forecastData],
                            borderColor: 'rgba(255, 215, 0, 1)',
                            borderDash: [5, 5],
                            pointRadius: 5,
                            pointBackgroundColor: 'rgba(255, 215, 0, 1)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: 'rgba(27, 38, 59, 1)',
                            pointHoverBorderColor: 'rgba(255, 215, 0, 1)',
                            fill: false,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(229, 231, 235, 0.5)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        @endif
    });
</script>
@endsection