@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8">
            <div class="card-custom">
                <div class="card-header-custom text-center">
                    <i class="fas fa-info-circle card-icon-header mb-3"></i>
                    <h2 class="card-title-custom">Tentang Proyek Ini</h2>
                    <p class="card-subtitle-custom">Akurasi dan Keandalan Data Kriminalitas Terkini.</p>
                </div>
                <div class="card-body-custom">
                    <p class="text-secondary mb-4">
                        Website ini dikembangkan sebagai proyek untuk memprediksi tingkat risiko kejahatan di berbagai Kepolisian Daerah di Indonesia. Proyek ini menggunakan kombinasi teknologi modern untuk analisis dan visualisasi data.
                    </p>
                    
                    <h4 class="card-title-body mb-3">Metodologi</h4>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="method-block">
                                <i class="fas fa-database icon-method"></i>
                                <h5 class="method-title">Pengumpulan Data</h5>
                                <p class="method-text">Data historis mengenai jumlah tindak pidana dikumpulkan dari sumber publik.</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="method-block">
                                <i class="fas fa-robot icon-method"></i>
                                <h5 class="method-title">Machine Learning</h5>
                                <p class="method-text">Menggunakan Python dan scikit-learn untuk model prediksi, khususnya Random Forest Classifier.</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="method-block">
                                <i class="fas fa-code icon-method"></i>
                                <h5 class="method-title">Framework Web</h5>
                                <p class="method-text">Menggunakan Laravel untuk membangun antarmuka web, mengelola rute, dan berinteraksi dengan model Python.</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="method-block">
                                <i class="fas fa-chart-pie icon-method"></i>
                                <h5 class="method-title">Visualisasi</h5>
                                <p class="method-text">Menggunakan Chart.js untuk menampilkan data statistik dalam bentuk diagram yang informatif.</p>
                            </div>
                        </div>
                    </div>
                    <p class="text-secondary mt-4">
                        Tujuan utama proyek ini adalah untuk memberikan wawasan tentang tren kejahatan dan membantu pihak terkait dalam perencanaan dan pencegahan.
                    </p>
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
    
    .card-title-body {
        font-weight: 700;
        color: var(--theme-primary);
        font-size: 1.8rem;
    }

    /* Method Blocks */
    .method-block {
        background-color: var(--bg-color);
        border-radius: 15px;
        padding: 20px;
        border: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        height: 100%;
        transition: all 0.3s ease;
    }
    .method-block:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.08);
    }

    .icon-method {
        font-size: 2.5rem;
        color: var(--theme-accent);
        margin-bottom: 15px;
    }

    .method-title {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 5px;
    }

    .method-text {
        font-size: 0.9rem;
        color: var(--text-secondary);
        margin-bottom: 0;
    }

    /* Animasi */
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>
@endsection