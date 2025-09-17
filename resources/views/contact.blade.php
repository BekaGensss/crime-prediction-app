@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-7">
            <div class="card-custom">
                <div class="card-header-custom text-center">
                    <i class="fas fa-envelope card-icon-header mb-3"></i>
                    <h2 class="card-title-custom">Hubungi Kami</h2>
                    <p class="card-subtitle-custom">Kami siap mendengar pertanyaan, masukan, atau ajakan kolaborasi Anda.</p>
                </div>
                <div class="card-body-custom text-center">
                    <p class="text-secondary mb-4">
                        Jika Anda memiliki pertanyaan, masukan, atau ingin berkolaborasi, silakan hubungi kami melalui informasi di bawah ini.
                    </p>
                    <ul class="list-unstyled contact-list">
                        <li>
                            <i class="fas fa-at icon-contact"></i>
                            <div class="contact-details">
                                <span class="contact-label">Email:</span>
                                <a href="mailto:contoh.email@example.com" class="contact-link">contoh.email@example.com</a>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-phone-alt icon-contact"></i>
                            <div class="contact-details">
                                <span class="contact-label">Telepon:</span>
                                <a href="tel:+6281234567890" class="contact-link">+62 812-3456-7890</a>
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

    /* Kontak Kustom */
    .contact-list {
        list-style: none;
        padding: 0;
        margin-top: 2rem;
    }

    .contact-list li {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        transition: transform 0.3s ease;
    }

    .contact-list li:hover {
        transform: translateY(-3px);
    }

    .icon-contact {
        font-size: 1.8rem;
        color: var(--theme-primary);
        margin-right: 1rem;
    }

    .contact-details {
        text-align: left;
    }

    .contact-label {
        font-weight: 600;
        color: var(--text-primary);
        display: block;
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
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>
@endsection