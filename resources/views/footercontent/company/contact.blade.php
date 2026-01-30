<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubungi Kami - KosKu</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #222;
            background: #fff;
            zoom:0.9;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
        }

        /* Hero Section */
        .hero {
            padding-top: 130px;
            background: linear-gradient(to bottom right, #000000, #000000);
            color: #fff;
            text-align: center;
            padding-bottom: 80px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 24px;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Contact Section */
        .section {
            padding: 80px 0;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 48px;
            margin-top: 48px;
        }

        .contact-form {
            background: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #eee;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 8px;
            color: #555;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: #222;
        }

        textarea.form-input {
            min-height: 150px;
            resize: vertical;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: #222;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .submit-btn:hover {
            background: #000;
        }

        .contact-info {
            padding: 28px;
            background: #fff;
            border-radius: 16px;
            border: 1px solid #eaeaea;
        }

        .contact-method {
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f0f0f0;
        }

        .contact-method:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .contact-method h3 {
            font-size: 0.98rem;
            font-weight: 600;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 9px;
            color: #111;
        }

        .contact-method h3 i {
            width: 18px;
            color: #111;
        }

        .contact-method p {
            color: #555;
            margin-bottom: 6px;
            font-size: 0.93rem;
        }

        .contact-method a {
            color: #222;
            text-decoration: none;
            font-weight: 400;
        }

        .contact-method a:hover {
            text-decoration: underline;
        }

        .social-links {
            display: flex;
            gap: 10px;
            margin-top: 8px;
        }

        .social-link {
            width: auto;
            height: auto;
            border-radius: 0;
            background: transparent;
            color: #111;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: color 0.2s ease;
            font-size: 1.15rem;
            border: none;
            box-shadow: none;
            padding: 3px 2px;
        }

        .social-link:hover {
            color: #000;
        }

        .map-container {
            margin-top: 80px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .map-container iframe {
            width: 100%;
            height: 450px;
            border: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .section {
                padding: 60px 0;
            }

            .contact-grid {
                gap: 32px;
            }

            .contact-form,
            .contact-info {
                padding: 24px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        @include('components.navbar')
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Hubungi Kami</h1>
            <p>Ada pertanyaan atau saran? Kami siap membantu Anda</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-form">
                    <form action="#" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-input" name="name" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-input" name="email" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Subjek</label>
                            <input type="text" class="form-input" name="subject" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Pesan</label>
                            <textarea class="form-input" name="message" required></textarea>
                        </div>
                        <button type="submit" class="submit-btn">Kirim Pesan</button>
                    </form>
                </div>

                <div class="contact-info">
                    <div class="contact-method">
                        <h3> Alamat</h3>
                        <p>Jl. Raya Bogor No. 123</p>
                        <p>Jakarta Timur, DKI Jakarta 13810</p>
                    </div>

                    <div class="contact-method">
                        <h3>Telepon</h3>
                        <p><a href="tel:+6285712345678">+62 857 1234 5678</a></p>
                        <p><a href="tel:+6221987654321">(021) 987-654-321</a></p>
                    </div>

                    <div class="contact-method">
                        <h3>Email</h3>
                        <p><a href="mailto:info@kosku.com">info@kosku.com</a></p>
                        <p><a href="mailto:support@kosku.com">support@kosku.com</a></p>
                    </div>

                    <div class="contact-method">
                        <h3>Jam Operasional</h3>
                        <p>Senin - Jumat: 09:00 - 18:00</p>
                        <p>Sabtu: 09:00 - 15:00</p>
                        <p>Minggu: Tutup</p>
                    </div>

                    <div class="contact-method">
                        <h3><i class="fas fa-share-alt"></i> Media Sosial</h3>
                        <div class="social-links">
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="map-container">                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.2968085645607!2d106.8700493!3d-6.2267956!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f38e1e6fe497%3A0xdbba63dd887c883f!2sJl.%20Raya%20Bogor%2C%20RT.1%2FRW.1%2C%20Kramat%20Jati%2C%20East%20Jakarta%20City%2C%20Jakarta%2013510!5e0!3m2!1sen!2sid!4v1685702433359!5m2!1sen!2sid"
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        @include('components.footer')
    </footer>
</body>
</html>