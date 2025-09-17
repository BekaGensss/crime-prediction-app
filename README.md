# Crime Prediction App

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Python](https://img.shields.io/badge/Python-3776AB?style=for-the-badge&logo=python&logoColor=white)
![GitHub](https://img.shields.io/badge/GitHub-100000?style=for-the-badge&logo=github&logoColor=white)

Aplikasi web untuk memprediksi tingkat kejahatan di berbagai Kepolisian Daerah di Indonesia menggunakan model Machine Learning. Proyek ini masih dalam tahap pengembangan aktif.

---

## 💻 Tentang Proyek

Proyek ini dibangun untuk menganalisis data kriminalitas historis dan memprediksi tingkat risiko di masa depan. Tujuan utama kami adalah untuk memberikan wawasan yang dapat membantu pihak terkait dalam perencanaan dan pencegahan kejahatan.

**Fitur Utama:**
* **Prediksi Tingkat Kejahatan:** Menggunakan model **Random Forest Classifier** dan **Decision Tree Classifier** untuk mengklasifikasikan risiko kejahatan (Rendah, Sedang, Tinggi).
* **Peramalan:** Memperkirakan jumlah kasus kejahatan di tahun-tahun mendatang.
* **Visualisasi Data:** Menampilkan statistik dan perbandingan data dalam bentuk grafik yang interaktif dan mudah dipahami.
* **Antarmuka Pengguna (UI) Modern:** Didesain dengan tampilan yang elegan dan profesional, memastikan pengalaman pengguna yang baik.

---

## 🛠️ Teknologi yang Digunakan

* **Backend:**
    * **Laravel Framework** (PHP)
    * **Python** (untuk model Machine Learning)
    * **Flask** (untuk API Python)

* **Frontend:**
    * **HTML, CSS, JavaScript**
    * **Bootstrap 5** (untuk responsivitas dan komponen UI)
    * **Chart.js** (untuk visualisasi data)
    * **Font Awesome** (untuk ikon)

* **Machine Learning:**
    * **scikit-learn**
    * **pandas**
    * **numpy**

---

## ⚙️ Instalasi dan Konfigurasi

### Prasyarat
Pastikan Anda sudah menginstal:
* [PHP](https://www.php.net/downloads.php) (Versi 8.1 atau lebih tinggi)
* [Composer](https://getcomposer.org/)
* [Node.js & npm](https://nodejs.org/en/download/)
* [Python](https://www.python.org/downloads/) (Versi 3.8 atau lebih tinggi)
* [Git](https://git-scm.com/downloads)

### Langkah-langkah
1.  **Clone Repositori:**
    ```bash
    git clone [https://github.com/BekaGensss/crime-prediction-app.git](https://github.com/BekaGensss/crime-prediction-app.git)
    cd crime-prediction-app
    ```

2.  **Instal Dependensi Laravel:**
    ```bash
    composer install
    npm install
    npm run dev
    ```

3.  **Konfigurasi Laravel:**
    * Salin file konfigurasi:
        ```bash
        cp .env.example .env
        ```
    * Buat kunci aplikasi:
        ```bash
        php artisan key:generate
        ```
    * Atur kredensial database Anda di file `.env`.

4.  **Siapkan API Python:**
    * Navigasi ke direktori `python_scripts`:
        ```bash
        cd python_scripts
        ```
    * Instal dependensi Python:
        ```bash
        pip install -r requirements.txt
        ```
    * Jalankan server API Flask:
        ```bash
        python app.py
        ```
    * Biarkan server ini berjalan di terminal terpisah.

5.  **Jalankan Aplikasi Laravel:**
    * Buka terminal baru dan jalankan server Laravel:
        ```bash
        php artisan serve
        ```
    * Aplikasi sekarang dapat diakses di `http://127.0.0.1:8000`.

---

## 🤝 Kontribusi

Proyek ini terbuka untuk kontribusi. Jika Anda memiliki saran, perbaikan, atau ingin menambahkan fitur baru, silakan ajukan **Pull Request** atau laporkan **Issues**.

---

## 📄 Lisensi

Proyek ini dirilis di bawah lisensi MIT.

---

