<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Prediksi Kejahatan Canggih</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Palet Warna & Variabel Global */
        :root {
            --bg-color: #F0F4F7;
            --surface-color: #E0E1DD;
            --card-color: #F8F9FB;
            --text-primary: #0D1B2A;
            --text-secondary: #4A4E69;
            --theme-primary: #1B263B;
            --theme-accent: #FFD700;
            --border-color: #CFD8DC;
            --shadow-light: #FFFFFF;
            --shadow-dark: #AAB7C4;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            line-height: 1.8;
            position: relative;
            z-index: 1;
            overflow-x: hidden;
        }

        /* Neumorphism Base Class */
        .neumorphism-card {
            background-color: var(--card-color);
            border-radius: 25px;
            box-shadow: 10px 10px 20px var(--shadow-dark), 
                        -10px -10px 20px var(--shadow-light);
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        .neumorphism-card:hover {
            box-shadow: 15px 15px 30px var(--shadow-dark), 
                        -15px -15px 30px var(--shadow-light);
            transform: translateY(-5px);
        }

        /* --- Glassmorphism Navbar --- */
        .navbar-glass {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(13, 27, 42, 0.1);
            padding: 1.5rem 3rem;
            z-index: 1020;
            border-radius: 0 0 25px 25px;
        }
        .navbar-brand-custom {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--text-primary) !important;
        }
        .navbar-brand-custom i {
            color: var(--theme-accent);
            margin-right: 0.5rem;
        }

        .nav-link-custom {
            font-weight: 500;
            color: var(--text-secondary) !important;
            padding: 1rem 1.8rem;
            border-radius: 50px;
            transition: all 0.4s ease;
            position: relative;
        }
        .nav-link-custom:hover {
            color: var(--theme-primary) !important;
            background-color: rgba(255, 255, 255, 0.6);
            transform: translateY(-2px);
        }
        .nav-link-custom.active {
            background-color: var(--theme-primary) !important;
            color: var(--surface-color) !important;
            box-shadow: 0 4px 15px rgba(27, 38, 59, 0.2);
            font-weight: 600;
        }
        
        /* --- Hero Section & Particles --- */
        #particles-js {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background-image: linear-gradient(120deg, var(--bg-color), #D6E0E7);
        }

        /* --- Card & Visuals --- */
        .card-header-custom {
            background-color: transparent;
            padding: 60px;
            border-bottom: 3px solid var(--theme-accent);
            text-align: center;
        }
        .card-icon-header {
            font-size: 4.5rem;
            color: var(--theme-accent);
            animation: fadeInScale 1.5s ease-in-out;
            margin-bottom: 1.5rem;
        }
        .card-title-custom {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 2.8rem;
            color: var(--text-primary);
        }
        .card-subtitle-custom {
            font-weight: 400;
            opacity: 0.9;
            color: var(--text-secondary);
        }
        .card-body-custom {
            padding: 50px;
        }

        .form-label-custom {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 1.1rem;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
        }
        .icon-form {
            color: var(--theme-primary);
            margin-right: 15px;
            font-size: 1.4rem;
        }
        .form-select-custom, .form-control-custom {
            border-radius: 18px;
            border: none;
            padding: 18px 25px;
            font-size: 1.1rem;
            color: var(--text-primary);
            background-color: var(--card-color);
            box-shadow: inset 5px 5px 10px var(--shadow-dark), 
                        inset -5px -5px 10px var(--shadow-light);
            transition: all 0.3s ease;
        }
        .form-select-custom:focus, .form-control-custom:focus {
            box-shadow: inset 2px 2px 5px var(--shadow-dark), 
                        inset -2px -2px 5px var(--shadow-light);
            background-color: var(--surface-color);
            outline: none;
        }

        /* --- Tombol Aksi --- */
        .btn-custom-primary {
            background-color: var(--theme-primary);
            background-image: linear-gradient(135deg, #1B263B 0%, #0D1B2A 100%);
            color: #FFD700;
            border: none;
            padding: 20px 35px;
            font-size: 1.2rem;
            font-weight: 700;
            border-radius: 50px;
            transition: all 0.4s ease;
            box-shadow: 8px 8px 15px rgba(13, 27, 42, 0.2);
            letter-spacing: 1px;
        }
        .btn-custom-primary:hover {
            transform: translateY(-5px);
            box-shadow: 12px 12px 25px rgba(13, 27, 42, 0.3);
            color: #FFF;
        }
        .btn-custom-secondary {
            background-color: transparent;
            color: var(--text-secondary);
            border: 2px solid var(--border-color);
            padding: 18px 35px;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        .btn-custom-secondary:hover {
            color: var(--theme-primary);
            border-color: var(--theme-primary);
            background-color: rgba(27, 38, 59, 0.05);
        }

        /* --- Hasil Prediksi --- */
        .result-box {
            background-color: var(--card-color);
            border-radius: 25px;
            padding: 50px;
            border: none;
            box-shadow: 8px 8px 15px var(--shadow-dark), 
                        -8px -8px 15px var(--shadow-light);
            animation: fadeIn 1s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        .result-title-custom {
            color: var(--theme-primary);
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 2rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        .result-prediction-custom {
            font-size: 4rem;
            font-weight: 700;
            color: var(--theme-primary);
            margin-top: 20px;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.1);
        }
        
        /* --- Animasi --- */
        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.8) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
    </style>
</head>
<body>
    <div id="particles-js"></div>

    <div class="content-wrap">
        <nav class="navbar navbar-expand-lg navbar-glass">
            <div class="container-fluid">
                <a class="navbar-brand-custom" href="{{ route('home') }}">
                    <i class="fas fa-shield-alt"></i> DataShield
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link-custom {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                <i class="fas fa-chart-line"></i> Prediksi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-custom {{ request()->routeIs('statistics') || request()->routeIs('location.detail') ? 'active' : '' }}" href="{{ route('statistics') }}">
                                <i class="fas fa-chart-bar"></i> Statistik
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-custom {{ request()->routeIs('forecast.form') ? 'active' : '' }}" href="{{ route('forecast.form') }}">
                                <i class="fas fa-cloud-sun"></i> Peramalan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-custom {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                                <i class="fas fa-info-circle"></i> Tentang Kami
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-custom {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                                <i class="fas fa-envelope"></i> Kontak
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-5">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script>
        particlesJS('particles-js', {
            "particles": {
                "number": {
                    "value": 100,
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": "#9DADB7"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    }
                },
                "opacity": {
                    "value": 0.6,
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
                    "distance": 150,
                    "color": "#CFD8DC",
                    "opacity": 0.5,
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