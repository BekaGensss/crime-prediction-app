@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row g-5 justify-content-center">
        <div class="col-md-4 col-lg-4">
            <div class="card-neomorphic">
                <div class="card-header-neomorphic">
                    <i class="fas fa-search-location header-icon"></i>
                    <h2 class="card-title-neomorphic mt-3 mb-1">Mulai Prediksi</h2>
                    <p class="card-subtitle-neomorphic">Pilih model dan lokasi.</p>
                </div>
                <div class="card-body-neomorphic">
                    <form id="predictionForm" method="POST" action="{{ route('predict.crime') }}" class="needs-validation" novalidate>
                        @csrf
                        
                        <div class="mb-3 form-group-neumorphic">
                            <label for="model-input" class="form-label-neumorphic">
                                <i class="fas fa-microchip icon-form me-2"></i> Model Prediksi
                            </label>
                            <div class="custom-dropdown" id="model-dropdown">
                                <input type="hidden" name="model" id="model-input" required value="rf">
                                <div class="dropdown-header">
                                    <span class="dropdown-selected-value">Random Forest Classifier</span>
                                    <i class="fas fa-caret-down dropdown-arrow"></i>
                                </div>
                                <ul class="dropdown-list">
                                    <li data-value="rf" class="selected">Random Forest Classifier</li>
                                    <li data-value="dt">Decision Tree Classifier</li>
                                    <li data-value="lr">Logistic Regression</li>
                                    <li data-value="svm">Support Vector Machine (SVM)</li>
                                </ul>
                            </div>
                        </div>

                        <div class="mb-4 form-group-neumorphic">
                            <label for="location-input" class="form-label-neumorphic">
                                <i class="fas fa-map-marked-alt icon-form me-2"></i> Lokasi
                            </label>
                            <div class="custom-dropdown" id="location-dropdown">
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
                                <i class="fas fa-chart-line me-2"></i> Proses Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-lg-8 d-flex align-items-center">
            <div id="result-panel" class="card-neomorphic p-5 w-100 min-vh-50 d-flex flex-column justify-content-center align-items-center">
                <i class="fas fa-arrow-left result-placeholder-icon mb-4"></i>
                <h4 class="result-placeholder-text">Pilih opsi di sisi kiri untuk melihat hasil.</h4>
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
    .result-content-container {
        width: 100%;
        animation: fadeInScale 1s cubic-bezier(0.25, 0.8, 0.25, 1);
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
    document.addEventListener('DOMContentLoaded', function() {
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
    });

    document.getElementById('predictionForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        const data = {
            model: formData.get('model'),
            location: formData.get('location')
        };
        const resultPanel = document.getElementById('result-panel');

        // Loading state
        resultPanel.innerHTML = `
            <div class="d-flex flex-column align-items-center">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-secondary mt-3">Memproses prediksi, mohon tunggu...</p>
            </div>
        `;

        fetch(form.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw new Error(errorData.error);
                });
            }
            return response.json();
        })
        .then(data => {
            resultPanel.innerHTML = `
                <div class="result-content-container text-center">
                    <i class="fas fa-chart-line text-primary mb-3" style="font-size: 4rem;"></i>
                    <h4 class="result-title-new">Hasil Analisis Kejahatan</h4>
                    <p class="result-info-text">Tingkat risiko di <strong>${data.location}</strong> menggunakan model <strong>${data.model_name}</strong>:</p>
                    <h3 class="result-prediction-new">${data.prediction}</h3>
                    <p class="result-prediction-label">Risiko Kejahatan</p>
                    <div class="mt-4">
                        <canvas id="predictionChart"></canvas>
                    </div>
                </div>
            `;
            
            const labels = ['Probabilitas Rendah', 'Probabilitas Tinggi'];
            const probabilities = data.probabilities;

            const ctx = document.getElementById('predictionChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Tingkat Probabilitas',
                        data: probabilities,
                        backgroundColor: [
                            'rgba(27, 38, 59, 0.6)',
                            'rgba(255, 215, 0, 0.8)'
                        ],
                        borderColor: [
                            'rgba(27, 38, 59, 1)',
                            'rgba(255, 215, 0, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 1,
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error:', error);
            resultPanel.innerHTML = `
                <div class="alert alert-danger fade show alert-neumorphic text-center w-100" role="alert">
                    <strong>Maaf!</strong> Terjadi kesalahan: ${error.message}.
                </div>
            `;
        });
    });
</script>
@endsection