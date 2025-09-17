@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-7">
            <div class="card-custom">
                <div class="card-header-custom text-center">
                    <i class="fas fa-balance-scale card-icon-header mb-3"></i>
                    <h2 class="card-title-custom">Perbandingan Statistik</h2>
                    <p class="card-subtitle-custom">Bandingkan data kriminalitas antar lokasi.</p>
                </div>
                <div class="card-body-custom">
                    @if (isset($error))
                        <div class="alert-custom alert-danger-custom text-center mb-4">
                            <i class="fas fa-exclamation-triangle me-2"></i> {{ $error }}
                        </div>
                    @else
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="compare-loc1" class="form-label-custom">
                                    <i class="fas fa-map-marker-alt icon-form"></i> Lokasi 1
                                </label>
                                <select class="form-select-custom" id="compare-loc1">
                                    <option value="all">-- Pilih Lokasi --</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location }}" {{ $compare1 == $location ? 'selected' : '' }}>{{ $location }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="compare-loc2" class="form-label-custom">
                                    <i class="fas fa-map-marker-alt icon-form"></i> Lokasi 2
                                </label>
                                <select class="form-select-custom" id="compare-loc2">
                                    <option value="all">-- Pilih Lokasi --</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location }}" {{ $compare2 == $location ? 'selected' : '' }}>{{ $location }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 d-flex justify-content-center mt-3">
                                <button class="btn-custom-primary w-50" id="compare-btn">
                                    <i class="fas fa-chart-bar me-2"></i> Bandingkan
                                </button>
                            </div>
                        </div>

                        <div class="hr-custom my-5"></div>

                        <h4 class="chart-title-custom text-center mb-4">Grafik Perbandingan</h4>
                        <canvas id="comparisonChart"></canvas>
                        
                        <div class="row text-center mt-5">
                            <div class="col-md-6">
                                <h4 class="text-secondary-title mb-2">Total Kejahatan 2022<br>{{ $compare1 }}</h4>
                                <h3 class="text-primary-value">
                                    {{ $comparisonData[0]['2022'] ?? 'N/A' }}
                                </h3>
                            </div>
                            <div class="col-md-6">
                                <h4 class="text-secondary-title mb-2">Total Kejahatan 2022<br>{{ $compare2 }}</h4>
                                <h3 class="text-primary-value">
                                    {{ $comparisonData[1]['2022'] ?? 'N/A' }}
                                </h3>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --bg-color: #F7F9FC;
        --surface-color: #FFFFFF;
        --text-primary: #1A1A1A;
        --text-secondary: #6B7280;
        --border-color: #E5E7EB;
        --accent-color: #1a1a1a;
        --accent-hover: #404040;
        --theme-primary: #1F2937;
        --theme-accent: #FFD700;
    }
    
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
    .form-select-custom {
        border-radius: 12px;
        border: 1px solid var(--border-color);
        padding: 15px 20px;
        font-size: 1rem;
        color: var(--text-primary);
        background-color: var(--bg-color);
        transition: all 0.3s ease;
    }
    .form-select-custom:focus {
        border-color: var(--theme-primary);
        box-shadow: 0 0 0 4px rgba(31, 41, 55, 0.15);
        background-color: var(--surface-color);
    }
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
    .hr-custom {
        height: 1px;
        background-color: var(--border-color);
    }
    .chart-title-custom {
        font-weight: 600;
        color: var(--text-primary);
    }
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
    .text-secondary-title {
        color: var(--text-secondary);
        font-weight: 500;
    }
    .text-primary-value {
        color: var(--theme-primary);
        font-weight: 700;
        font-size: 2.5rem;
    }
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const compare1 = @json($compare1);
        const compare2 = @json($compare2);
        const comparisonData = @json($comparisonData);
        
        // Logika untuk menampilkan grafik hanya jika kedua lokasi dipilih
        if (compare1 !== 'all' && compare2 !== 'all') {
            const chartLabels = ['2021', '2022'];
            const location1Data = comparisonData.find(item => item.location === compare1);
            const location2Data = comparisonData.find(item => item.location === compare2);
            
            const datasets = [];
            if (location1Data) {
                datasets.push({
                    label: `Jumlah Kejahatan ${compare1}`,
                    data: [location1Data['2021'], location1Data['2022']],
                    backgroundColor: 'rgba(31, 41, 55, 0.8)', // Dark Blue
                    borderColor: 'rgba(31, 41, 55, 1)',
                    borderWidth: 1,
                    borderRadius: 5
                });
            }
            if (location2Data) {
                datasets.push({
                    label: `Jumlah Kejahatan ${compare2}`,
                    data: [location2Data['2021'], location2Data['2022']],
                    backgroundColor: 'rgba(255, 215, 0, 0.8)', // Gold
                    borderColor: 'rgba(255, 215, 0, 1)',
                    borderWidth: 1,
                    borderRadius: 5
                });
            }

            const ctx = document.getElementById('comparisonChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#E5E7EB' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                color: '#1A1A1A'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                }
                            }
                        }
                    }
                }
            });
        }
    });

    // Event listeners
    document.getElementById('compare-btn').addEventListener('click', function() {
        const loc1 = document.getElementById('compare-loc1').value;
        const loc2 = document.getElementById('compare-loc2').value;
        if (loc1 !== 'all' && loc2 !== 'all') {
            window.location.href = `{{ route('statistics') }}?banding1=${loc1}&banding2=${loc2}`;
        }
    });
</script>
@endsection