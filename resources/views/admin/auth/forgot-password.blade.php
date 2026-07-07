<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>Lupa Password Admin — Pivot Cafe</title>
    
    <!-- Google Fonts & FontAwesome (dengan preconnect) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Playfair+Display:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        *, *::before, *::after { 
            box-sizing: border-box; 
            margin: 0; 
            padding: 0; 
        }
        
        :root {
            --primary: #1b4332;
            --primary-dark: #081c15;
            --primary-light: #2d6a4f;
            --accent: #d4a373;
            --accent-light: #faedcd;
            --accent-dark: #b5835a;
            --text-gelap: #1c2024;
            --text-terang: #606d7b;
            --putih: #ffffff;
            --danger: #e63946;
            --danger-bg: #fff5f5;
            --success: #2d6a4f;
            --success-bg: #f0f7f4;
            --shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            --radius: 24px;
        }

        body {
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
            background: linear-gradient(135deg, rgba(8, 28, 21, 0.85) 0%, rgba(20, 22, 26, 0.9) 100%),
                        url('{{ asset("images/display-main.png") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        @media (max-width: 768px) {
            body {
                background-attachment: scroll;
            }
        }

        .wadah-utama {
            display: flex;
            width: 100%;
            max-width: 1100px;
            min-height: 650px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            animation: muncul 0.6s ease both;
            position: relative;
            z-index: 1;
        }

        @keyframes muncul {
            from { 
                opacity: 0; 
                transform: scale(0.95) translateY(30px); 
            }
            to { 
                opacity: 1; 
                transform: scale(1) translateY(0); 
            }
        }

        .sisi-kiri {
            flex: 1.2;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: var(--putih);
            background: linear-gradient(135deg, rgba(27, 67, 50, 0.6) 0%, rgba(8, 28, 21, 0.3) 100%);
            position: relative;
        }

        .identitas-brand {
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
            z-index: 1;
        }

        .logo-box {
            width: 54px;
            height: 54px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .logo-box:hover {
            transform: scale(1.05);
            background: rgba(255, 255, 255, 0.15);
        }

        .logo-box img { 
            width: 30px; 
            height: 30px; 
            object-fit: contain; 
        }

        .identitas-brand span { 
            font-size: 20px; 
            font-weight: 700; 
            letter-spacing: 2px; 
            text-transform: uppercase;
            background: linear-gradient(135deg, #fff 0%, rgba(255,255,255,0.7) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .kutipan-visual {
            max-width: 420px;
            position: relative;
            z-index: 1;
        }

        .lencana-konsol {
            font-size: 11px;
            color: var(--accent-light);
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            margin-bottom: 20px;
            display: inline-block;
            background: rgba(255, 255, 255, 0.08);
            padding: 8px 18px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
        }

        .kutipan-visual h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.2rem;
            line-height: 1.2;
            font-weight: 900;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            margin-bottom: 12px;
        }

        .kutipan-visual p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.6;
        }

        .kaki-kiri { 
            font-size: 12px; 
            color: rgba(255, 255, 255, 0.25); 
            letter-spacing: 0.5px;
            position: relative;
            z-index: 1;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sisi-kanan {
            flex: 1;
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 50px 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-left: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
        }

        .kartu-form { 
            width: 100%; 
            max-width: 400px;
        }

        .header-form { 
            margin-bottom: 32px; 
        }

        .lencana-admin {
            display: inline-block;
            padding: 6px 16px;
            background: var(--accent-light);
            color: var(--primary-dark);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            border-radius: 10px;
            margin-bottom: 16px;
            box-shadow: 0 4px 15px rgba(212, 163, 115, 0.2);
        }

        .header-form h2 { 
            font-family: 'Playfair Display', serif; 
            font-size: 34px; 
            font-weight: 900; 
            color: var(--primary-dark);
            margin-bottom: 8px;
        }

        .header-form p { 
            font-size: 14px; 
            color: var(--text-terang); 
            line-height: 1.6; 
        }

        .toast-container {
            position: fixed;
            top: 30px;
            right: 30px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-width: 450px;
            width: 100%;
            pointer-events: none;
        }

        .toast {
            background: var(--putih);
            padding: 18px 24px;
            border-radius: 16px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: flex-start;
            gap: 14px;
            animation: slideInRight 0.3s ease both;
            pointer-events: auto;
            border-left: 5px solid var(--success);
            transform: translateX(0);
            transition: all 0.3s ease;
        }

        .toast.hiding {
            transform: translateX(120%);
            opacity: 0;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(120%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .toast-icon {
            width: 42px;
            height: 42px;
            min-width: 42px;
            background: var(--success-bg);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--success);
            font-size: 20px;
        }

        .toast-content {
            flex: 1;
        }

        .toast-content h4 {
            font-size: 15px;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 4px;
        }

        .toast-content p {
            font-size: 13px;
            color: var(--text-terang);
            line-height: 1.4;
            margin: 0;
        }

        .toast-close {
            background: none;
            border: none;
            color: var(--text-terang);
            cursor: pointer;
            padding: 4px;
            font-size: 18px;
            transition: all 0.3s ease;
            pointer-events: auto;
            margin-top: -4px;
        }

        .toast-close:hover {
            color: var(--text-gelap);
            transform: rotate(90deg);
        }

        .error-field,
        input.error {
            border-color: var(--danger) !important;
            background: var(--danger-bg) !important;
        }

        .error-message {
            color: var(--danger);
            font-size: 12px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .grup-form { 
            margin-bottom: 20px; 
            position: relative; 
        }

        label { 
            display: block; 
            font-size: 12px; 
            font-weight: 600; 
            margin-bottom: 6px; 
            color: var(--primary-dark); 
            text-transform: uppercase; 
            letter-spacing: 0.8px;
        }

        label .required {
            color: var(--danger);
            margin-left: 4px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid rgba(0, 0, 0, 0.06);
            border-radius: 14px;
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            background: #f8f9fa;
            transition: all 0.3s ease;
            color: var(--text-gelap);
        }

        input:focus { 
            outline: none; 
            border-color: var(--primary); 
            background: var(--putih); 
            transform: translateY(-2px); 
            box-shadow: 0 8px 25px rgba(27, 67, 50, 0.1);
        }

        input::placeholder {
            color: #adb5bd;
            font-size: 14px;
        }

        .tombol-masuk {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 14px;
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            margin-top: 8px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            position: relative;
            overflow: hidden;
        }
        
        .tombol-masuk::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: all 0.5s ease;
        }

        .tombol-masuk:hover::before {
            left: 100%;
        }

        .tombol-masuk:hover { 
            transform: translateY(-3px); 
            box-shadow: 0 12px 30px rgba(27, 67, 50, 0.3);
        }

        .tombol-masuk:active {
            transform: translateY(0);
        }

        .tombol-masuk:disabled {
            opacity: 0.75;
            cursor: not-allowed;
            transform: none;
        }

        .teks-bantuan { 
            margin-top: 24px; 
            font-size: 12.5px; 
            color: var(--text-terang); 
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(0,0,0,0.05);
        }

        .teks-bantuan i {
            color: var(--accent);
            margin: 0 4px;
        }

        .teks-bantuan a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .teks-bantuan a:hover {
            color: var(--primary-light);
            text-decoration: underline;
        }

        .spinner {
            display: inline-block;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 968px) {
            .sisi-kiri { 
                display: none; 
            }
            .sisi-kanan { 
                border-radius: var(--radius); 
                border-left: none; 
                box-shadow: 0 30px 80px rgba(0, 0, 0, 0.4);
                padding: 40px 30px;
            }
            .wadah-utama {
                min-height: auto;
                background: rgba(255, 255, 255, 0.95);
            }
            .toast-container {
                top: 20px;
                right: 20px;
                left: 20px;
                max-width: 100%;
            }
        }

        @media (max-width: 480px) {
            .sisi-kanan {
                padding: 30px 20px;
            }
            .header-form h2 {
                font-size: 28px;
            }
            input {
                font-size: 14px;
                padding: 12px 14px;
            }
            .toast {
                padding: 14px 18px;
            }
        }
    </style>
</head>
<body>

    <div class="toast-container" id="toastContainer"></div>

    <div class="wadah-utama">
        <section class="sisi-kiri">
            <div class="identitas-brand">
                <div class="logo-box">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Pivot" loading="lazy">
                </div>
                <span>Pivot Cafe</span>
            </div>
            <div class="kutipan-visual">
                <span class="lencana-konsol">
                    <i class="fas fa-envelope" style="margin-right: 6px;"></i>
                    Lupa Password
                </span>
                <h1>Kirim Tautan Reset</h1>
                <p>Masukkan email terdaftar untuk menerima tautan reset password ke kotak masuk Anda.</p>
            </div>
            <div class="kaki-kiri">
                <i class="far fa-copyright" style="margin-right: 4px;"></i> 2026 Pivot Cafe — Semua hak dilindungi
            </div>
        </section>

        <section class="sisi-kanan">
            <div class="kartu-form">
                <div class="header-form">
                    <span class="lencana-admin">
                        <i class="fas fa-key" style="margin-right: 6px;"></i>
                        PEMULIHAN AKUN
                    </span>
                    <h2>Lupa Password?</h2>
                    <p>Kami akan kirimkan tautan reset ke email Anda</p>
                </div>

                <form method="POST" action="{{ route('admin.password.email') }}" id="formForgot" novalidate>
                    @csrf

                    <div class="grup-form" id="emailGroup">
                        <label for="email">
                            Alamat Email
                            <span class="required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                required 
                                autofocus 
                                placeholder="admin@pivotcaffe.com"
                                value="{{ old('email') }}"
                                class="{{ $errors->has('email') ? 'error' : '' }}"
                            >
                        </div>
                        <div id="emailError" class="error-message" style="display: none;">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>Email tidak valid</span>
                        </div>
                    </div>
                    
                    <button type="submit" class="tombol-masuk" id="btnKirim">
                        <span id="teksTombol">Kirim Link Reset</span>
                        <i class="fas fa-paper-plane" style="font-size: 14px; transition: transform 0.3s ease;"></i>
                    </button>
                </form>

                <div class="teks-bantuan">
                    <i class="fas fa-arrow-left"></i>
                    <a href="{{ route('admin.login') }}">Kembali ke Halaman Login</a>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            function showToast(title, message, type = 'success') {
                const container = document.getElementById('toastContainer');

                const iconMap = {
                    success: 'fa-check-circle',
                    error: 'fa-exclamation-circle',
                    warning: 'fa-exclamation-triangle',
                    info: 'fa-info-circle'
                };

                const colorMap = {
                    success: 'var(--success)',
                    error: 'var(--danger)',
                    warning: '#f59e0b',
                    info: '#3b82f6'
                };

                const toast = document.createElement('div');
                toast.className = 'toast';
                toast.style.borderLeftColor = colorMap[type] || colorMap.success;

                toast.innerHTML = `
                    <div class="toast-icon" style="color: ${colorMap[type]}; background: ${colorMap[type]}10;">
                        <i class="fas ${iconMap[type] || iconMap.success}"></i>
                    </div>
                    <div class="toast-content">
                        <h4>${title}</h4>
                        <p>${message}</p>
                    </div>
                    <button class="toast-close" onclick="this.closest('.toast').classList.add('hiding'); setTimeout(() => this.closest('.toast').remove(), 300);">
                        <i class="fas fa-times"></i>
                    </button>
                `;

                container.appendChild(toast);

                setTimeout(() => {
                    toast.classList.add('hiding');
                    setTimeout(() => {
                        if (toast.parentNode) toast.remove();
                    }, 300);
                }, 5000);
            }

            @if ($errors->any())
                showToast('Gagal', @json($errors->first('email')), 'error');
            @endif

            @if (session('status'))
                showToast('Berhasil', @json(session('status')), 'success');
            @endif

            const form = document.getElementById('formForgot');
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('emailError');

            function validateEmail(email) {
                const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                return re.test(email);
            }

            function showEmailError(message) {
                emailError.style.display = 'flex';
                emailError.querySelector('span').textContent = message;
                emailInput.classList.add('error');
            }

            function hideEmailError() {
                emailError.style.display = 'none';
                emailInput.classList.remove('error');
            }

            emailInput.addEventListener('blur', function() {
                const email = this.value.trim();
                if (!email) {
                    showEmailError('Email wajib diisi');
                } else if (!validateEmail(email)) {
                    showEmailError('Masukkan alamat email yang valid (contoh: admin@pivotcaffe.com)');
                } else {
                    hideEmailError();
                }
            });

            emailInput.addEventListener('input', function() {
                const email = this.value.trim();
                if (!email) {
                    showEmailError('Email wajib diisi');
                } else if (!validateEmail(email)) {
                    showEmailError('Format email tidak valid');
                } else {
                    hideEmailError();
                }
            });

            emailInput.addEventListener('focus', function() {
                if (this.classList.contains('error')) hideEmailError();
            });

            form.addEventListener('submit', function(e) {
                const email = emailInput.value.trim();

                if (!email || !validateEmail(email)) {
                    e.preventDefault();
                    showEmailError(!email ? 'Email wajib diisi' : 'Format email tidak valid');
                    emailInput.focus();
                    return;
                }

                hideEmailError();

                const btn = document.getElementById('btnKirim');
                const teksTombol = document.getElementById('teksTombol');
                const icon = btn.querySelector('.fa-paper-plane');

                btn.disabled = true;
                teksTombol.innerHTML = '<span class="spinner"></span> Mengirim...';
                icon.style.display = 'none';
            });
        });
    </script>
</body>
</html>