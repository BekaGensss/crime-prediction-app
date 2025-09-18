@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card-neomorphic">
                <div class="card-header-neomorphic text-center">
                    <i class="fas fa-balance-scale header-icon"></i>
                    <h2 class="card-title-neomorphic mt-3 mb-1">Perbandingan Akurasi Model</h2>
                    <p class="card-subtitle-neomorphic">Membandingkan performa model klasifikasi kejahatan.</p>
                </div>
                <div class="card-body-neomorphic">
                    @if (isset($error))
                        <div class="alert alert-danger fade show alert-neumorphic text-center" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i> {{ $error }}
                        </div>
                    @else
                        <h4 class="chart-title-neumorphic text-center mb-4">Akurasi Model (%)</h4>
                        <canvas id="accuracyChart"></canvas>
                    @endif
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
    .chart-title-neumorphic {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        color: var(--theme-primary);
        font-size: 1.5rem;
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
</style>

<script>
    @if (isset($comparisonData))
        const comparisonData = @json($comparisonData);
        
        const labels = ['Random Forest', 'Decision Tree', 'Logistic Regression', 'SVM'];
        const data = [
            comparisonData.rf_accuracy,
            comparisonData.dt_accuracy,
            comparisonData.lr_accuracy,
            comparisonData.svm_accuracy
        ];

        const ctx = document.getElementById('accuracyChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Akurasi (%)',
                    data: data,
                    backgroundColor: [
                        'rgba(27, 38, 59, 0.8)',
                        'rgba(255, 215, 0, 0.8)',
                        'rgba(0, 123, 255, 0.8)',
                        'rgba(220, 53, 69, 0.8)'
                    ],
                    borderColor: [
                        'rgba(27, 38, 59, 1)',
                        'rgba(255, 215, 0, 1)',
                        'rgba(0, 123, 255, 1)',
                        'rgba(220, 53, 69, 1)'
                    ],
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: { color: 'rgba(229, 231, 235, 0.5)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: {
                        display: false
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
                                return context.dataset.label + ': ' + context.raw + '%';
                            }
                        }
                    }
                }
            }
        });
    @endif
</script>
@endsection