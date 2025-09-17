@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-7">
            <div class="card-custom">
                <div class="card-header-custom text-center">
                    <i class="fas fa-microchip card-icon-header mb-3"></i>
                    <h2 class="card-title-custom">Perbandingan Model</h2>
                    <p class="card-subtitle-custom">Membandingkan Akurasi Model Prediksi.</p>
                </div>
                <div class="card-body-custom">
                    @if (isset($error))
                        <div class="alert-custom alert-danger-custom text-center mb-4">
                            <i class="fas fa-exclamation-triangle me-2"></i> {{ $error }}
                        </div>
                    @else
                        <p class="text-center text-secondary mb-4">
                            Diagram di bawah ini menunjukkan akurasi dari dua model prediksi yang berbeda.
                        </p>
                        <canvas id="comparisonChart"></canvas>
                        
                        <div class="hr-custom my-5"></div>
                        
                        <div class="row text-center">
                            <div class="col-md-6 mb-4">
                                <h4 class="text-secondary-title mb-2">Akurasi Random Forest</h4>
                                <h3 class="text-primary-value">{{ $comparisonData['rf_accuracy'] }}%</h3>
                            </div>
                            <div class="col-md-6 mb-4">
                                <h4 class="text-secondary-title mb-2">Akurasi Decision Tree</h4>
                                <h3 class="text-primary-value">{{ $comparisonData['dt_accuracy'] }}%</h3>
                            </div>
                        </div>
                    @endif
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
        background-color: var(--theme-primary);
        color: var(--surface-color);
        padding: 40px;
        border-bottom: 2px solid var(--theme-accent);
        border-radius: 20px 20px 0 0;
    }

    .card-icon-header {
        font-size: 3.5rem;
        color: var(--theme-accent);
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
    
    /* Notifikasi Kustom */
    .alert-custom {
        border-radius: 12px;
        padding: 1.5rem;
        font-weight: 500;
    }
    .alert-danger-custom {
        background-color: #FEE2E2;
        color: #991B1B;
        border: 1px solid #FCA5A5;
    }

    /* Garis Pemisah */
    .hr-custom {
        height: 1px;
        background-color: var(--border-color);
    }
    
    /* Teks Nilai Kustom */
    .text-secondary-title {
        color: var(--text-secondary);
        font-weight: 500;
    }
    .text-primary-value {
        color: var(--theme-primary);
        font-weight: 700;
        font-size: 2.5rem;
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
</style>

@if (isset($comparisonData))
<script>
    const comparisonData = @json($comparisonData);
    const ctx = document.getElementById('comparisonChart').getContext('2d');
    
    // Konfigurasi umum grafik
    const chartOptions = {
        responsive: true,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(31, 41, 55, 0.9)',
                titleColor: '#FFD700',
                bodyColor: '#FFFFFF',
                callbacks: {
                    label: function(context) {
                        return context.dataset.label + ': ' + context.raw + '%';
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 100,
                grid: { color: '#E5E7EB' },
                ticks: {
                    color: '#6B7280',
                }
            },
            x: {
                grid: { display: false },
                ticks: {
                    color: '#6B7280',
                }
            }
        }
    };

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Random Forest', 'Decision Tree'],
            datasets: [{
                label: 'Akurasi',
                data: [comparisonData.rf_accuracy, comparisonData.dt_accuracy],
                backgroundColor: [
                    'rgba(31, 41, 55, 0.8)', // Dark Blue
                    'rgba(255, 215, 0, 0.8)' // Gold
                ],
                borderColor: [
                    'rgba(31, 41, 55, 1)',
                    'rgba(255, 215, 0, 1)'
                ],
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: chartOptions
    });
</script>
@endif
@endsection