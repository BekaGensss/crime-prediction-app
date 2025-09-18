@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-7">
            <div class="card-neomorphic">
                <div class="card-header-neomorphic text-center">
                    <i class="fas fa-envelope header-icon"></i>
                    <h2 class="card-title-neomorphic mt-3 mb-1">Hubungi Kami</h2>
                    <p class="card-subtitle-neomorphic">Kami siap mendengar pertanyaan, masukan, atau ajakan kolaborasi Anda.</p>
                </div>
                <div class="card-body-neomorphic text-center">
                    <p class="text-secondary mb-4 lead">
                        Jika Anda memiliki pertanyaan, masukan, atau ingin berkolaborasi, silakan hubungi kami melalui informasi di bawah ini.
                    </p>
                    <ul class="list-unstyled contact-list-neumorphic">
                        <li>
                            <div class="contact-block-neumorphic">
                                <i class="fas fa-at icon-contact"></i>
                                <div class="contact-details">
                                    <span class="contact-label">Email:</span>
                                    <a href="mailto:contoh.email@example.com" class="contact-link">contoh.email@example.com</a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="contact-block-neumorphic">
                                <i class="fas fa-phone-alt icon-contact"></i>
                                <div class="contact-details">
                                    <span class="contact-label">Telepon:</span>
                                    <a href="tel:+6281234567890" class="contact-link">+62 812-3456-7890</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <p class="mt-5 text-secondary">
                        Terima kasih atas kunjungan Anda!
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

    /* Kontak Kustom Neumorphism */
    .contact-list-neumorphic {
        list-style: none;
        padding: 0;
        margin-top: 2rem;
    }
    .contact-block-neumorphic {
        background-color: var(--card-color);
        border-radius: 15px;
        box-shadow: 5px 5px 10px var(--shadow-dark), 
                    -5px -5px 10px var(--shadow-light);
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }
    .contact-block-neumorphic:hover {
        transform: translateY(-5px);
        box-shadow: 8px 8px 15px rgba(0, 0, 0, 0.08);
    }
    .icon-contact {
        font-size: 2rem;
        color: var(--theme-primary);
        margin-right: 1.5rem;
    }
    .contact-details {
        text-align: left;
    }
    .contact-label {
        font-weight: 600;
        color: var(--text-primary);
        display: block;
        font-size: 1.1rem;
    }
    .contact-link {
        color: var(--text-secondary);
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .contact-link:hover {
        color: var(--theme-primary);
        text-decoration: underline;
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