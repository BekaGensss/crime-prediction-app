<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Prediksi Tingkat Kejahatan</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Palet Warna & Variabel Global */
        :root {
            --bg-color: #F7F9FC;
            --surface-color: #FFFFFF;
            --text-primary: #121212;
            --text-secondary: #5C5C5C;
            --accent-color: #007BFF; /* Biru terang yang profesional */
            --accent-hover: #0056b3;
            --border-color: #E5E7EB;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }

        /* --- Navbar yang Sempurna --- */
        .navbar {
            background-color: var(--surface-color) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 1rem 2rem;
            border-bottom: 1px solid var(--border-color);
            z-index: 1020;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--text-primary) !important;
            transition: color 0.3s ease;
        }

        .navbar-brand:hover {
            color: var(--text-secondary) !important;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-secondary) !important;
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        /* Garis bawah interaktif yang dinamis */
        .nav-link::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%) scaleX(0);
            width: 100%;
            height: 3px;
            background-color: var(--accent-color);
            transition: transform 0.3s ease;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            transform: translateX(-50%) scaleX(1);
        }

        .nav-link.active {
            color: var(--accent-color) !important;
            font-weight: 600;
        }

        /* Tata letak mobile */
        @media (max-width: 991.98px) {
            .nav-link {
                padding: 0.75rem 0;
            }
            .nav-link::after {
                display: none;
            }
            .nav-link.active {
                border-left: 3px solid var(--accent-color);
                border-radius: 0;
                padding-left: 1rem;
            }
        }
        
        /* --- Partikel yang Kelihatan --- */
        #particles-js {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        /* --- Card & Visual Lainnya --- */
        .card {
            background-color: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
            cursor: pointer;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .card-body {
            padding: 2.5rem;
        }

        .card-title {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 1.4rem;
            margin-bottom: 1rem;
        }

        .card-text {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .btn-primary {
            background-color: var(--accent-color);
            border: none;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:hover {
            background-color: var(--accent-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        .form-control {
            background-color: var(--surface-color);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 8px;
            padding: 12px 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.15);
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div id="particles-js"></div>

    <div class="content-wrap">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <i class="fas fa-shield-alt"></i> Prediksi Kejahatan
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                <i class="fas fa-chart-line"></i> Prediksi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('statistics') || request()->routeIs('location.detail') ? 'active' : '' }}" href="{{ route('statistics') }}">
                                <i class="fas fa-chart-bar"></i> Statistik
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('forecast.form') ? 'active' : '' }}" href="{{ route('forecast.form') }}">
                                <i class="fas fa-cloud-sun"></i> Peramalan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                                <i class="fas fa-info-circle"></i> Tentang Kami
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                                <i class="fas fa-envelope"></i> Kontak
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>

    <script>
        particlesJS('particles-js', {
            "particles": {
                "number": {
                    "value": 100, /* Kerapatan partikel lebih tinggi */
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": "#1A1A1A" /* Warna partikel hitam */
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    }
                },
                "opacity": {
                    "value": 0.5, /* Opasitas lebih tinggi agar lebih terlihat */
                    "random": false,
                    "anim": {
                        "enable": false
                    }
                },
                "size": {
                    "value": 3,
                    "random": true,
                    "anim": {
                        "enable": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 120, /* Jarak garis lebih pendek */
                    "color": "#1A1A1A",
                    "opacity": 0.4, /* Garis lebih terlihat */
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 2,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false,
                    "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "grab"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 140,
                        "line_linked": {
                            "opacity": 1
                        }
                    },
                    "push": {
                        "particles_nb": 4
                    }
                }
            },
            "retina_detect": true
        });
    </script>
</body>
</html>