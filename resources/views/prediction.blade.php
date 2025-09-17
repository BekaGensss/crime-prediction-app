@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-7">
            <div class="card-custom">
                <div class="card-header-custom text-center">
                    <i class="fas fa-chart-line card-icon-header mb-3"></i>
                    <h2 class="card-title-custom">Prediksi Tingkat Kejahatan</h2>
                    <p class="card-subtitle-custom">Akurasi dan Keandalan Data Kriminalitas Terkini.</p>
                </div>
                <div class="card-body-custom">
                    <form id="predictionForm" method="POST" action="{{ route('predict.crime') }}" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-4 form-group-custom">
                            <label for="model" class="form-label-custom">
                                <i class="fas fa-microchip icon-form"></i> Pilih Model Prediksi
                            </label>
                            <select class="form-select-custom" id="model" name="model" required>
                                <option value="rf">Random Forest Classifier</option>
                                <option value="dt">Decision Tree Classifier</option>
                            </select>
                        </div>
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
                                <i class="fas fa-search-location me-2"></i> Mulai Prediksi
                            </button>
                        </div>
                    </form>

                    <div class="hr-custom my-5"></div>

                    <div id="result" class="text-center">
                        </div>
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

    /* Hasil Prediksi */
    .result-box {
        background-color: var(--bg-color);
        border-radius: 15px;
        padding: 30px;
        border: 1px solid var(--border-color);
    }

    .result-title {
        color: var(--text-primary);
        font-weight: 600;
    }

    .result-prediction {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--theme-primary);
        margin-top: 15px;
    }

    /* Animasi */
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>

<script>
    document.getElementById('predictionForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        const data = {
            model: formData.get('model'),
            location: formData.get('location')
        };

        const resultDiv = document.getElementById('result');
        
        // Animasi loading yang lebih elegan
        resultDiv.innerHTML = `
            <div class="result-box d-flex flex-column align-items-center">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-secondary mb-0">Memproses prediksi, mohon tunggu sebentar...</p>
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
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                resultDiv.innerHTML = `<div class="result-box alert-danger">
                    <h5 class="result-title">Error!</h5>
                    <p class="mb-0">${data.error}</p>
                </div>`;
            } else {
                resultDiv.innerHTML = `
                    <div class="result-box">
                        <h4 class="result-title">Hasil Prediksi</h4>
                        <p class="text-secondary">Tingkat risiko kejahatan di lokasi yang dipilih adalah:</p>
                        <h3 class="result-prediction">${data.prediction}</h3>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            resultDiv.innerHTML = `<div class="result-box alert-danger">
                <h5 class="result-title">Error!</h5>
                <p class="mb-0">Terjadi kesalahan. Silakan coba lagi.</p>
            </div>`;
        });
    });
</script>
@endsection