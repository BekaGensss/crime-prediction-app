@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card-custom">
                <div class="card-header-custom text-center">
                    <i class="fas fa-search-location card-icon-header mb-3"></i>
                    <h2 class="card-title-custom">Statistik Detail untuk {{ $lokasi }}</h2>
                    <p class="card-subtitle-custom">Analisis Mendalam Data Kriminalitas di Wilayah Ini.</p>
                </div>
                <div class="card-body-custom">
                    <p class="text-center text-secondary mb-4">
                        Data tindak pidana di **{{ $lokasi }}** pada tahun 2021 dan 2022.
                    </p>

                    <h4 class="chart-title-custom text-center mb-4">Perbandingan Jumlah Kejahatan dengan Rata-rata Nasional</h4>
                    <canvas id="comparisonChart"></canvas>

                    <div class="hr-custom my-5"></div>
                    
                    <h4 class="chart-title-custom text-center mb-4">Tingkat Penyelesaian Tindak Pidana</h4>
                    <canvas id="resolutionChart"></canvas>
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

    /* Garis Pemisah */
    .hr-custom {
        height: 1px;
        background-color: var(--border-color);
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

<script>
    const lokasi = @json($lokasi);
    const locationData = @json($locationData);
    const avg2021 = @json($avg2021);
    const avg2022 = @json($avg2022);
    const totalSolved2021 = @json($totalSolved2021);
    const totalSolved2022 = @json($totalSolved2022);

    // Konfigurasi umum grafik
    const chartOptions = {
        responsive: true,
        plugins: {
            legend: {
                labels: {
                    color: '#1F2937', // Warna label dark blue
                    font: {
                        family: 'Inter',
                        size: 14,
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(31, 41, 55, 0.9)',
                titleColor: '#FFD700',
                bodyColor: '#FFFFFF',
                bodyFont: {
                    family: 'Inter'
                },
                titleFont: {
                    family: 'Inter'
                },
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
                grid: { color: '#E5E7EB' },
                ticks: {
                    color: '#6B7280',
                    font: { family: 'Inter' }
                }
            },
            x: {
                grid: { display: false },
                ticks: {
                    color: '#6B7280',
                    font: { family: 'Inter' }
                }
            }
        }
    };

    // Grafik Perbandingan
    const comparisonCtx = document.getElementById('comparisonChart').getContext('2d');
    new Chart(comparisonCtx, {
        type: 'bar',
        data: {
            labels: ['2021', '2022'],
            datasets: [{
                label: `Jumlah Kejahatan di ${lokasi}`,
                data: [locationData['Jumlah Tindak Pidana 2021'], locationData['Jumlah Tindak Pidana 2022']],
                backgroundColor: 'rgba(31, 41, 55, 0.8)', // Dark Blue
                borderColor: 'rgba(31, 41, 55, 1)',
                borderWidth: 1,
                borderRadius: 5
            }, {
                label: 'Rata-rata Nasional',
                data: [avg2021, avg2022],
                backgroundColor: 'rgba(255, 215, 0, 0.8)', // Gold
                borderColor: 'rgba(255, 215, 0, 1)',
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: chartOptions
    });

    // Grafik Penyelesaian
    const resolutionCtx = document.getElementById('resolutionChart').getContext('2d');
    new Chart(resolutionCtx, {
        type: 'doughnut',
        data: {
            labels: ['Selesai', 'Belum Selesai'],
            datasets: [{
                data: [totalSolved2022, 100 - totalSolved2022],
                backgroundColor: [
                    'rgba(31, 41, 55, 0.8)', // Dark Blue
                    'rgba(255, 215, 0, 0.8)' // Gold
                ],
                borderColor: ['rgba(31, 41, 55, 1)', 'rgba(255, 215, 0, 1)'],
                borderWidth: 1,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#1A1A1A',
                        font: { family: 'Inter' }
                    }
                },
                tooltip: chartOptions.plugins.tooltip,
                title: {
                    display: true,
                    text: 'Tingkat Penyelesaian 2022',
                    color: '#1A1A1A',
                    font: {
                        family: 'Inter',
                        size: 16,
                        weight: '600'
                    }
                }
            }
        }
    });
</script>
@endsection