@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card-neomorphic">
                <div class="card-header-neomorphic text-center">
                    <i class="fas fa-search-location header-icon"></i>
                    <h2 class="card-title-neomorphic mt-3 mb-1">Statistik Detail untuk {{ $lokasi }}</h2>
                    <p class="card-subtitle-neomorphic">Analisis Mendalam Data Kriminalitas di Wilayah Ini.</p>
                </div>
                <div class="card-body-neomorphic">
                    <p class="text-center text-secondary mb-4">
                        Data tindak pidana di <strong>{{ $lokasi }}</strong> pada tahun 2021 dan 2022.
                    </p>

                    <h4 class="chart-title-neumorphic text-center mb-4">Perbandingan Jumlah Kejahatan dengan Rata-rata Nasional</h4>
                    <canvas id="comparisonChart"></canvas>

                    <div class="hr-custom my-5"></div>
                    
                    <h4 class="chart-title-neumorphic text-center mb-4">Tingkat Penyelesaian Tindak Pidana</h4>
                    <canvas id="resolutionChart"></canvas>
                </div>
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

    /* Card Neumorphism */
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
        padding: 40px;
    }

    /* Garis Pemisah */
    .hr-custom {
        height: 1px;
        background-color: var(--border-color);
    }

    /* Grafik */
    .chart-title-neumorphic {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        color: var(--theme-primary);
        font-size: 1.5rem;
    }
    
    /* Animasi */
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }
    @keyframes rotateIn {
        from { transform: rotateY(90deg) scale(0.5); opacity: 0; }
        to { transform: rotateY(0deg) scale(1); opacity: 1; }
    }
</style>

<script>
    const lokasi = @json($lokasi);
    const locationData = @json($locationData);
    const avg2021 = @json($avg2021);
    const avg2022 = @json($avg2022);
    const totalSolved2021 = parseFloat(@json($totalSolved2021));
    const totalSolved2022 = parseFloat(@json($totalSolved2022));

    // Konfigurasi umum grafik
    const chartOptions = {
        responsive: true,
        plugins: {
            legend: {
                labels: {
                    color: 'var(--text-primary)',
                    font: {
                        family: 'Inter',
                        size: 14,
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(13, 27, 42, 0.9)',
                titleColor: 'var(--theme-accent)',
                bodyColor: 'var(--surface-color)',
                bodyFont: {
                    family: 'Inter'
                },
                titleFont: {
                    family: 'Inter'
                },
                callbacks: {
                    label: function(context) {
                        if (context.dataset.type === 'doughnut') {
                            const value = context.raw;
                            return `${context.label}: ${value}%`;
                        }
                        return `${context.dataset.label}: ${new Intl.NumberFormat('id-ID').format(context.raw)}`;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(229, 231, 235, 0.5)' },
                ticks: {
                    color: 'var(--text-secondary)',
                    font: { family: 'Inter' }
                }
            },
            x: {
                grid: { display: false },
                ticks: {
                    color: 'var(--text-secondary)',
                    font: { family: 'Inter' }
                }
            }
        }
    };
    
    // Grafik Perbandingan
    const comparisonCtx = document.getElementById('comparisonChart').getContext('2d');
    const comparisonChart = new Chart(comparisonCtx, {
        type: 'bar',
        data: {
            labels: ['2021', '2022'],
            datasets: [{
                label: `Jumlah Kejahatan di ${lokasi}`,
                data: [
                    parseInt(locationData['Jumlah_Tindak_Pidana_2021'].replace(/,/g, '')),
                    parseInt(locationData['Jumlah_Tindak_Pidana_2022'].replace(/,/g, ''))
                ],
                backgroundColor: 'rgba(27, 38, 59, 0.8)',
                borderColor: 'rgba(27, 38, 59, 1)',
                borderWidth: 1,
                borderRadius: 5
            }, {
                label: 'Rata-rata Nasional',
                data: [avg2021, avg2022],
                backgroundColor: 'rgba(255, 215, 0, 0.8)',
                borderColor: 'rgba(255, 215, 0, 1)',
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: chartOptions
    });

    // Grafik Penyelesaian
    const resolutionCtx = document.getElementById('resolutionChart').getContext('2d');
    const resolutionChart = new Chart(resolutionCtx, {
        type: 'doughnut',
        data: {
            labels: ['Selesai', 'Belum Selesai'],
            datasets: [{
                data: [totalSolved2022, 100 - totalSolved2022],
                backgroundColor: [
                    'rgba(27, 38, 59, 0.8)', // Dark Blue
                    'rgba(255, 215, 0, 0.8)' // Gold
                ],
                borderColor: ['rgba(27, 38, 59, 1)', 'rgba(255, 215, 0, 1)'],
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
                        color: 'var(--text-primary)',
                        font: { family: 'Inter' }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(13, 27, 42, 0.9)',
                    titleColor: 'var(--theme-accent)',
                    bodyColor: 'var(--surface-color)',
                    bodyFont: {
                        family: 'Inter'
                    },
                    titleFont: {
                        family: 'Inter'
                    },
                    callbacks: {
                        label: function(context) {
                            const value = context.raw;
                            return `${context.label}: ${value}%`;
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Tingkat Penyelesaian 2022',
                    color: 'var(--text-primary)',
                    font: {
                        family: 'Playfair Display',
                        size: 16,
                        weight: '600'
                    }
                }
            }
        }
    });
</script>
@endsection