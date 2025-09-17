@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-7">
            <div class="card-custom">
                <div class="card-header-custom text-center">
                    <i class="fas fa-chart-line card-icon-header mb-3"></i>
                    <h2 class="card-title-custom">Peramalan Jumlah Tindak Pidana</h2>
                    <p class="card-subtitle-custom">Memprediksi jumlah kasus kejahatan di tahun mendatang.</p>
                </div>
                <div class="card-body-custom">
                    @if (session('error'))
                        <div class="alert-custom alert-danger-custom text-center mb-4">
                            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    @if (session('forecastData'))
                        <div class="result-box result-success text-center mb-4">
                            <h4 class="result-title-custom mb-3">Hasil Peramalan</h4>
                            <p class="result-text-custom">Perkiraan jumlah kasus di **{{ session('forecastData')['lokasi'] }}** pada tahun 2023 adalah:</p>
                            <h3 class="result-prediction-custom">{{ number_format(session('forecastData')['forecast_2023'], 0, ',', '.') }}</h3>
                        </div>
                        <div id="chart-container" class="mt-4">
                            <h4 class="chart-title-custom text-center mb-4">Grafik Data dan Peramalan</h4>
                            <canvas id="forecastChart"></canvas>
                        </div>
                        <div class="hr-custom my-5"></div>
                    @endif

                    <form id="forecastForm" action="{{ route('forecast.submit') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-4 form-group-custom">
                            <label for="location" class="form-label-custom">
                                <i class="fas fa-map-marked-alt icon-form"></i> Pilih Lokasi
                            </label>
                            <select class="form-select-custom" id="location" name="location" required>
                                <option value="">-- Pilih Kepolisian Daerah --</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location }}">{{ $location }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn-custom-primary">
                                <i class="fas fa-search-dollar me-2"></i> Ramalkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Mengambil variabel dari layout utama */
    :root {
        --text-primary: #1A1A1A;
        --text-secondary: #6B7280;
        --surface-color: #FFFFFF;
        --border-color: #E5E7EB;
        --accent-color: #1a1a1a;
        --accent-hover: #404040;
        /* Warna Baru untuk Tema Profesional */
        --theme-primary: #1F2937; /* Dark Blue */
        --theme-accent: #FFD700;  /* Gold */
    }

    /* Card yang Ditingkatkan */
    .card-custom {
        background-color: var(--surface-color);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s ease-in-out;
        border: 1px solid var(--border-color);
    }

    .card-custom:hover {
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        transform: translateY(-5px);
    }

    .card-header-custom {
        background-color: var(--theme-primary); /* Latar belakang header gelap */
        color: var(--surface-color);
        padding: 40px;
        border-bottom: 2px solid var(--theme-accent);
        border-radius: 20px 20px 0 0;
    }

    .card-icon-header {
        font-size: 3.5rem;
        color: var(--theme-accent); /* Ikon berwarna gold */
        animation: pulse 2s infinite ease-in-out;
    }

    .card-title-custom {
        font-weight: 700;
        font-size: 2.2rem;
        margin-bottom: 0.5rem;
        color: var(--surface-color);
    }

    .card-subtitle-custom {
        font-weight: 400;
        opacity: 0.8;
        color: var(--surface-color);
    }

    .card-body-custom {
        padding: 40px;
    }

    /* Formulir & Input */
    .form-label-custom {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 1rem;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    .icon-form {
        color: var(--theme-primary);
        margin-right: 10px;
        font-size: 1.2rem;
    }

    .form-select-custom, .form-control-custom {
        border-radius: 12px;
        border: 1px solid var(--border-color);
        padding: 15px 20px;
        font-size: 1rem;
        color: var(--text-primary);
        background-color: var(--bg-color);
        transition: all 0.3s ease;
    }

    .form-select-custom:focus, .form-control-custom:focus {
        border-color: var(--theme-primary);
        box-shadow: 0 0 0 4px rgba(31, 41, 55, 0.15);
        background-color: var(--surface-color);
    }

    /* Tombol Kustom */
    .btn-custom-primary {
        background-color: var(--theme-primary);
        color: var(--surface-color);
        border: none;
        padding: 18px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-custom-primary:hover {
        background-color: var(--accent-hover);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .btn-custom-primary:active {
        transform: translateY(0);
        box-shadow: none;
    }

    /* Garis Pemisah */
    .hr-custom {
        height: 1px;
        background-color: var(--border-color);
    }

    /* Hasil Peramalan */
    .result-box {
        background-color: var(--bg-color);
        border-radius: 15px;
        padding: 30px;
        border: 1px solid var(--border-color);
        animation: fadeIn 0.8s ease-in-out;
    }

    .result-success {
        border-left: 5px solid var(--theme-primary);
    }

    .result-title-custom {
        color: var(--theme-primary);
        font-weight: 600;
        margin-bottom: 10px;
    }

    .result-text-custom {
        color: var(--text-secondary);
        font-size: 1rem;
    }

    .result-prediction-custom {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--theme-primary);
        margin-top: 15px;
    }

    /* Grafik */
    .chart-title-custom {
        font-weight: 600;
        color: var(--text-primary);
    }

    /* Animasi */
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if (session('forecastData'))
            const data = @json(session('forecastData'));
            const ctx = document.getElementById('forecastChart').getContext('2d');
            const existingChart = Chart.getChart(ctx);
            if (existingChart) {
                existingChart.destroy();
            }

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['2021', '2022', '2023 (Peramalan)'],
                    datasets: [{
                        label: 'Jumlah Tindak Pidana',
                        data: [data.data_2021, data.data_2022, data.forecast_2023],
                        backgroundColor: [
                            'rgba(31, 41, 55, 0.7)',  /* Warna Dark Blue */
                            'rgba(255, 215, 0, 0.7)', /* Warna Gold */
                            'rgba(0, 123, 255, 0.7)'  /* Warna Biru Aksen */
                        ],
                        borderColor: [
                            'rgba(31, 41, 55, 1)',
                            'rgba(255, 215, 0, 1)',
                            'rgba(0, 123, 255, 1)'
                        ],
                        borderWidth: 1,
                        borderRadius: 5
                    }]
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
                                color: '#E5E7EB'
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