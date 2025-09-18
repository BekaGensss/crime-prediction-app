@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8">
            <div class="card-neomorphic">
                <div class="card-header-neomorphic text-center">
                    <i class="fas fa-info-circle header-icon"></i>
                    <h2 class="card-title-neomorphic mt-3 mb-1">Tentang Proyek Ini</h2>
                    <p class="card-subtitle-neomorphic">Penggunaan teknologi modern untuk analisis kejahatan.</p>
                </div>
                <div class="card-body-neomorphic">
                    <p class="text-secondary mb-5 lead text-center">
                        Website ini dikembangkan sebagai proyek untuk memprediksi tingkat risiko kejahatan di berbagai Kepolisian Daerah di Indonesia. Proyek ini menggunakan kombinasi teknologi modern untuk analisis dan visualisasi data.
                    </p>
                    
                    <h4 class="chart-title-neumorphic text-center mb-4">Metodologi</h4>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="method-block-neomorphic">
                                <i class="fas fa-database icon-method"></i>
                                <h5 class="method-title-neumorphic">Pengumpulan Data</h5>
                                <p class="method-text-neumorphic">Data historis mengenai jumlah tindak pidana dikumpulkan dari sumber publik.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="method-block-neomorphic">
                                <i class="fas fa-robot icon-method"></i>
                                <h5 class="method-title-neumorphic">Machine Learning</h5>
                                <p class="method-text-neumorphic">Menggunakan Python dan scikit-learn untuk model prediksi, seperti Random Forest Classifier.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="method-block-neomorphic">
                                <i class="fas fa-code icon-method"></i>
                                <h5 class="method-title-neumorphic">Framework Web</h5>
                                <p class="method-text-neumorphic">Menggunakan Laravel untuk membangun antarmuka web, mengelola rute, dan berinteraksi dengan model Python.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="method-block-neomorphic">
                                <i class="fas fa-chart-pie icon-method"></i>
                                <h5 class="method-title-neumorphic">Visualisasi Data</h5>
                                <p class="method-text-neumorphic">Menggunakan Chart.js untuk menampilkan data statistik dalam bentuk diagram yang informatif.</p>
                            </div>
                        </div>
                    </div>
                    <p class="text-secondary mt-5 text-center">
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

    .chart-title-neumorphic {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        color: var(--theme-primary);
        font-size: 1.5rem;
    }
    
    /* Method Blocks Neumorphism */
    .method-block-neomorphic {
        background-color: var(--bg-color);
        border-radius: 15px;
        box-shadow: inset 5px 5px 10px var(--shadow-dark), 
                    inset -5px -5px 10px var(--shadow-light);
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        height: 100%;
        transition: all 0.3s ease;
    }
    .method-block-neomorphic:hover {
        transform: translateY(-5px);
        box-shadow: 8px 8px 15px rgba(0, 0, 0, 0.08);
    }
    .icon-method {
        font-size: 2.5rem;
        color: var(--theme-accent);
        margin-bottom: 15px;
    }
    .method-title-neumorphic {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 5px;
    }
    .method-text-neumorphic {
        font-size: 0.9rem;
        color: var(--text-secondary);
        margin-bottom: 0;
    }

    /* Animasi */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes rotateIn {
        from { transform: rotateY(90deg) scale(0.5); opacity: 0; }
        to { transform: rotateY(0deg) scale(1); opacity: 1; }
    }
</style>
@endsection