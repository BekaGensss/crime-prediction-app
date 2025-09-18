@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card-neomorphic">
                <div class="card-header-neomorphic text-center">
                    <i class="fas fa-chart-bar header-icon"></i>
                    <h2 class="card-title-neomorphic mt-3 mb-1">Statistik Jumlah Tindak Pidana</h2>
                    <p class="card-subtitle-neomorphic">Analisis Visual Data Kriminalitas Berdasarkan Lokasi dan Waktu.</p>
                </div>
                <div class="card-body-neomorphic">
                    @if ($errors->any())
                        <div class="alert alert-danger fade show alert-neumorphic text-center mb-4" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i> {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="row mb-5 g-4">
                        <div class="col-md-4">
                            <label for="filter-tahun" class="form-label-neumorphic">
                                <i class="fas fa-calendar-alt icon-form me-2"></i> Filter Tahun
                            </label>
                            <div class="custom-dropdown">
                                <input type="hidden" name="filter-tahun-input" id="filter-tahun-input" required value="{{ $filterYear }}">
                                <div class="dropdown-header">
                                    <span class="dropdown-selected-value">{{ $filterYear == 'all' ? 'Semua Tahun' : $filterYear }}</span>
                                    <i class="fas fa-caret-down dropdown-arrow"></i>
                                </div>
                                <ul class="dropdown-list">
                                    <li data-value="all" class="{{ $filterYear == 'all' ? 'selected' : '' }}">Semua Tahun</li>
                                    <li data-value="2021" class="{{ $filterYear == '2021' ? 'selected' : '' }}">2021</li>
                                    <li data-value="2022" class="{{ $filterYear == '2022' ? 'selected' : '' }}">2022</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="filter-resiko" class="form-label-neumorphic">
                                <i class="fas fa-shield-alt icon-form me-2"></i> Filter Tingkat Risiko
                            </label>
                            <div class="custom-dropdown">
                                <input type="hidden" name="filter-resiko-input" id="filter-resiko-input" required value="{{ $filterRisk }}">
                                <div class="dropdown-header">
                                    <span class="dropdown-selected-value">{{ $filterRisk == 'all' ? 'Semua Risiko' : $filterRisk }}</span>
                                    <i class="fas fa-caret-down dropdown-arrow"></i>
                                </div>
                                <ul class="dropdown-list">
                                    <li data-value="all" class="{{ $filterRisk == 'all' ? 'selected' : '' }}">Semua Risiko</li>
                                    <li data-value="High" class="{{ $filterRisk == 'High' ? 'selected' : '' }}">Tinggi</li>
                                    <li data-value="Medium" class="{{ $filterRisk == 'Medium' ? 'selected' : '' }}">Sedang</li>
                                    <li data-value="Low" class="{{ $filterRisk == 'Low' ? 'selected' : '' }}">Rendah</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button class="btn-neumorphic-secondary w-100" id="reset-filter">
                                <i class="fas fa-sync-alt me-2"></i> Reset Filter
                            </button>
                        </div>
                    </div>
                    
                    <div class="hr-custom my-5"></div>

                    <div class="row mb-5 g-4">
                        <div class="col-md-6">
                            <label for="compare-loc1-input" class="form-label-neumorphic">
                                <i class="fas fa-location-arrow icon-form me-2"></i> Bandingkan Lokasi 1
                            </label>
                            <div class="custom-dropdown">
                                <input type="hidden" name="compare-loc1-input" id="compare-loc1-input" required value="{{ $compare1 }}">
                                <div class="dropdown-header">
                                    <span class="dropdown-selected-value">{{ $compare1 == 'all' ? '-- Pilih Lokasi --' : $compare1 }}</span>
                                    <i class="fas fa-caret-down dropdown-arrow"></i>
                                </div>
                                <ul class="dropdown-list">
                                    <li data-value="all" class="{{ $compare1 == 'all' ? 'selected' : '' }}">-- Pilih Lokasi --</li>
                                    @foreach($locations as $location)
                                        <li data-value="{{ $location }}" class="{{ $compare1 == $location ? 'selected' : '' }}">{{ $location }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="compare-loc2-input" class="form-label-neumorphic">
                                <i class="fas fa-location-arrow icon-form me-2"></i> Bandingkan Lokasi 2
                            </label>
                            <div class="custom-dropdown">
                                <input type="hidden" name="compare-loc2-input" id="compare-loc2-input" required value="{{ $compare2 }}">
                                <div class="dropdown-header">
                                    <span class="dropdown-selected-value">{{ $compare2 == 'all' ? '-- Pilih Lokasi --' : $compare2 }}</span>
                                    <i class="fas fa-caret-down dropdown-arrow"></i>
                                </div>
                                <ul class="dropdown-list">
                                    <li data-value="all" class="{{ $compare2 == 'all' ? 'selected' : '' }}">-- Pilih Lokasi --</li>
                                    @foreach($locations as $location)
                                        <li data-value="{{ $location }}" class="{{ $compare2 == $location ? 'selected' : '' }}">{{ $location }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-center mt-3">
                            <button class="btn-neumorphic-primary w-50" id="compare-btn">
                                <i class="fas fa-chart-line me-2"></i> Bandingkan
                            </button>
                        </div>
                    </div>

                    <div class="hr-custom my-5"></div>
                    
                    <h4 class="chart-title-neumorphic text-center mb-4">Diagram Batang (Bar Chart)</h4>
                    <canvas id="barChart"></canvas>
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
    
    .form-label-neumorphic {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 1rem;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
    }
    .icon-form {
        color: var(--theme-primary);
        margin-right: 10px;
        font-size: 1.2rem;
    }

    /* --- Gaya untuk Dropdown Kustom --- */
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
    .btn-neumorphic-secondary {
        background-color: var(--card-color);
        color: var(--text-secondary);
        border: none;
        padding: 16px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 12px;
        transition: all 0.3s ease;
        box-shadow: 6px 6px 12px var(--shadow-dark), 
                    -6px -6px 12px var(--shadow-light);
    }
    .btn-neumorphic-secondary:hover {
        transform: translateY(-3px);
        box-shadow: 8px 8px 15px var(--shadow-dark), 
                    -8px -8px 15px var(--shadow-light);
        color: var(--text-primary);
    }

    .hr-custom {
        height: 1px;
        background-color: var(--border-color);
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
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes rotateIn {
        from { transform: rotateY(90deg) scale(0.5); opacity: 0; }
        to { transform: rotateY(0deg) scale(1); opacity: 1; }
    }
</style>

<script>
    const labels = @json($labels);
    const chartData = @json($chartData);
    const filterYear = @json($filterYear);
    const compare1 = @json($compare1);
    const compare2 = @json($compare2);
    const locations = @json($locations);
    
    let chartLabels = labels;
    let chartDatasets = [];
    if (compare1 === 'all' && compare2 === 'all') {
        if (filterYear === 'all' || filterYear === '2021') {
            chartDatasets.push({
                label: 'Jumlah Tindak Pidana 2021',
                data: chartData.map(item => item['2021']),
                backgroundColor: 'rgba(31, 41, 55, 0.8)',
                borderColor: 'rgba(31, 41, 55, 1)',
                borderWidth: 1,
                borderRadius: 5
            });
        }
        if (filterYear === 'all' || filterYear === '2022') {
            chartDatasets.push({
                label: 'Jumlah Tindak Pidana 2022',
                data: chartData.map(item => item['2022']),
                backgroundColor: 'rgba(255, 215, 0, 0.8)',
                borderColor: 'rgba(255, 215, 0, 1)',
                borderWidth: 1,
                borderRadius: 5
            });
        }
    } else {
        chartLabels = ['2021', '2022'];
        const location1Data = chartData.find(item => item.location === compare1);
        const location2Data = chartData.find(item => item.location === compare2);

        if (location1Data) {
            chartDatasets.push({
                label: `Jumlah Kejahatan ${compare1}`,
                data: [location1Data['2021'], location1Data['2022']],
                backgroundColor: 'rgba(31, 41, 55, 0.8)',
                borderColor: 'rgba(31, 41, 55, 1)',
                borderWidth: 1,
                borderRadius: 5
            });
        }
        if (location2Data) {
            chartDatasets.push({
                label: `Jumlah Kejahatan ${compare2}`,
                data: [location2Data['2021'], location2Data['2022']],
                backgroundColor: 'rgba(255, 215, 0, 0.8)',
                borderColor: 'rgba(255, 215, 0, 1)',
                borderWidth: 1,
                borderRadius: 5
            });
        }
    }

    const barCtx = document.getElementById('barChart').getContext('2d');
    const existingChart = Chart.getChart(barCtx);
    if (existingChart) {
        existingChart.destroy();
    }

    const barChart = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: chartDatasets
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(229, 231, 235, 0.5)' }
                },
                x: {
                    grid: { display: false }
                }
            },
            plugins: {
                legend: {
                    display: (compare1 !== 'all' || compare2 !== 'all'),
                    position: 'top',
                    labels: {
                        color: 'var(--text-primary)'
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + new Intl.NumberFormat('id-ID').format(context.raw);
                        }
                    }
                }
            },
            onClick: function(e) {
                if (compare1 === 'all' && compare2 === 'all') {
                    const activePoints = barChart.getElementsAtEventForMode(e, 'nearest', { intersect: true }, false);
                    if (activePoints.length > 0) {
                        const firstPoint = activePoints[0];
                        const label = barChart.data.labels[firstPoint.index];
                        window.location.href = `/statistik/${label}`;
                    }
                }
            }
        }
    });

    // --- Skrip untuk Dropdown Kustom ---
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
                
                if (dropdown.id === 'filter-tahun-dropdown' || dropdown.id === 'filter-resiko-dropdown') {
                    applyFilters();
                }
            });
        });

        document.addEventListener('click', (event) => {
            if (!dropdown.contains(event.target)) {
                dropdown.classList.remove('open');
            }
        });
    });

    // Fungsi untuk menerapkan filter
    function applyFilters() {
        const year = document.getElementById('filter-tahun-input').value;
        const risk = document.getElementById('filter-resiko-input').value;
        const url = new URL(window.location.href);
        url.searchParams.set('tahun', year);
        url.searchParams.set('resiko', risk);
        url.searchParams.delete('banding1');
        url.searchParams.delete('banding2');
        window.location.href = url.toString();
    }
    
    document.getElementById('reset-filter').addEventListener('click', function() {
        window.location.href = `{{ route('statistics') }}`;
    });
    
    document.getElementById('compare-btn').addEventListener('click', function() {
        const loc1 = document.getElementById('compare-loc1-input').value;
        const loc2 = document.getElementById('compare-loc2-input').value;
        if (loc1 !== 'all' && loc2 !== 'all' && loc1 !== loc2) {
            const url = new URL(window.location.href);
            url.searchParams.set('banding1', loc1);
            url.searchParams.set('banding2', loc2);
            url.searchParams.delete('tahun');
            url.searchParams.delete('resiko');
            window.location.href = url.toString();
        } else if (loc1 === loc2 && loc1 !== 'all') {
            alert('Silakan pilih lokasi yang berbeda untuk membandingkan.');
        } else {
             alert('Silakan pilih dua lokasi untuk membandingkan.');
        }
    });

</script>
@endsection