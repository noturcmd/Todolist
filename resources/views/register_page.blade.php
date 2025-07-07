<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - To-Do App</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            background: #ffffff;
            border: 2px solid #e3f2fd;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 40px rgba(25, 118, 210, 0.1);
            transform: translateY(0);
            transition: all 0.3s ease;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(25, 118, 210, 0.15);
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #1976d2, #2196f3);
            border-radius: 15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        h2 {
            color: #2d3748;
            font-size: 28px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #718096;
            text-align: center;
            margin-bottom: 30px;
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #4a5568;
            font-weight: 600;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8fafc;
            color: #2d3748;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #1976d2;
            background: white;
            box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
            transform: translateY(-2px);
        }

        .input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            transition: color 0.3s ease;
        }

        input:focus+.input-icon {
            color: #1976d2;
        }

        .error-message {
            color: #e53e3e;
            font-size: 12px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .register-button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #1976d2, #2196f3);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .register-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .register-button:hover::before {
            left: 100%;
        }

        .register-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(25, 118, 210, 0.3);
        }

        .register-button:active {
            transform: translateY(0);
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            color: #718096;
            font-size: 14px;
        }

        .login-link a {
            color: #1976d2;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #2196f3;
            text-decoration: underline;
        }

        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
            color: #a0aec0;
            font-size: 14px;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e2e8f0;
            z-index: 1;
        }

        .divider span {
            background: #ffffff;
            padding: 0 15px;
            position: relative;
            z-index: 2;
        }

        /* Password strength indicator */
        .password-strength {
            margin-top: 8px;
            height: 4px;
            background: #e2e8f0;
            border-radius: 2px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak {
            background: #f56565;
            width: 25%;
        }

        .strength-fair {
            background: #ed8936;
            width: 50%;
        }

        .strength-good {
            background: #38b2ac;
            width: 75%;
        }

        .strength-strong {
            background: #68d391;
            width: 100%;
        }

        /* Success Popup Styles */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .popup-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .popup-content {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
            transform: scale(0.7) translateY(50px);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .popup-overlay.show .popup-content {
            transform: scale(1) translateY(0);
        }

        .success-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4caf50, #8bc34a);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 40px;
            animation: scaleIn 0.6s ease 0.3s both;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .popup-title {
            font-size: 24px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 10px;
            animation: slideInUp 0.6s ease 0.5s both;
        }

        .popup-message {
            color: #718096;
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 30px;
            animation: slideInUp 0.6s ease 0.7s both;
        }

        @keyframes slideInUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .popup-buttons {
            display: flex;
            gap: 15px;
            animation: slideInUp 0.6s ease 0.9s both;
        }

        .popup-button {
            flex: 1;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .popup-button.primary {
            background: linear-gradient(135deg, #1976d2, #2196f3);
            color: white;
        }

        .popup-button.primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(25, 118, 210, 0.3);
        }

        .popup-button.secondary {
            background: #f8fafc;
            color: #4a5568;
            border: 2px solid #e2e8f0;
        }

        .popup-button.secondary:hover {
            background: #e2e8f0;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .register-container {
                padding: 30px 25px;
                margin: 10px;
            }

            h2 {
                font-size: 24px;
            }

            .logo-icon {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }

            .popup-content {
                padding: 30px 25px;
            }

            .popup-buttons {
                flex-direction: column;
            }
        }

        /* Animasi untuk input error */
        .shake {
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        /* Form validation styling */
        .valid {
            border-color: #38a169;
            background: #f0fff4;
        }

        .invalid {
            border-color: #e53e3e;
            background: #fef5e7;
        }

        /* Loading state for button */
        .register-button.loading {
            opacity: 0.8;
            cursor: not-allowed;
        }

        .register-button.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            margin: auto;
            border: 2px solid transparent;
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 1s ease infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Error popup styles */
        .error-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f56565, #e53e3e);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 40px;
            animation: scaleIn 0.6s ease 0.3s both;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="logo">
            <div class="logo-icon">✓</div>
            <h2>Daftar To-Do App</h2>
            <p class="subtitle">Buat akun baru untuk memulai</p>
        </div>

        <form id="registerForm" action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    placeholder="Masukkan nama lengkap Anda" />
                @error('name')
                    <div class="error-message">
                        <span>⚠️</span>
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    placeholder="Masukkan email Anda" />
                @error('email')
                    <div class="error-message">
                        <span>⚠️</span>
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Buat password yang kuat" />
                <div class="password-strength">
                    <div class="password-strength-bar" id="strengthBar"></div>
                </div>
                @error('password')
                    <div class="error-message">
                        <span>⚠️</span>
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    placeholder="Ulangi password Anda" />
                <div id="passwordMatch" class="error-message" style="display: none;">
                    <span>⚠️</span>
                    <small>Password tidak cocok</small>
                </div>
            </div>

            <button class="register-button" type="submit" id="registerBtn">
                Daftar Sekarang
            </button>
        </form>

        <div class="divider">
            <span>atau</span>
        </div>

        <div class="login-link">
            Sudah punya akun? <a href="{{ route('login.form') }}">Login di sini</a>
        </div>
    </div>

    <!-- Success Popup -->
    <div class="popup-overlay" id="successPopup">
        <div class="popup-content">
            <div class="success-icon">✓</div>
            <h3 class="popup-title">Registrasi Berhasil!</h3>
            <p class="popup-message">
                Selamat! Akun Anda telah berhasil dibuat. Sekarang Anda dapat login dan mulai menggunakan To-Do App.
            </p>
            <div class="popup-buttons">
                <button class="popup-button primary" onclick="redirectToLogin()">
                    Login Sekarang
                </button>
                <button class="popup-button secondary" onclick="closePopup()">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Error Popup -->
    <div class="popup-overlay" id="errorPopup">
        <div class="popup-content">
            <div class="error-icon">✕</div>
            <h3 class="popup-title">Registrasi Gagal!</h3>
            <p class="popup-message" id="errorMessage">
                Terjadi kesalahan saat mendaftar. Silakan periksa data Anda dan coba lagi.
            </p>
            <div class="popup-buttons">
                <button class="popup-button primary" onclick="closeErrorPopup()">
                    Coba Lagi
                </button>
            </div>
        </div>
    </div>

    <script>
        // Animasi shake untuk input error
        document.addEventListener('DOMContentLoaded', function() {
            const errorInputs = document.querySelectorAll('.form-group:has(.error-message) input');
            errorInputs.forEach(input => {
                input.classList.add('shake');
            });
        });

        // Smooth focus effect
        const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Password strength checker
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('strengthBar');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = checkPasswordStrength(password);

            strengthBar.className = 'password-strength-bar';

            if (password.length === 0) {
                strengthBar.style.width = '0%';
            } else if (strength < 2) {
                strengthBar.classList.add('strength-weak');
            } else if (strength < 3) {
                strengthBar.classList.add('strength-fair');
            } else if (strength < 4) {
                strengthBar.classList.add('strength-good');
            } else {
                strengthBar.classList.add('strength-strong');
            }
        });

        function checkPasswordStrength(password) {
            let strength = 0;

            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            return strength;
        }

        // Password confirmation checker
        const confirmPassword = document.getElementById('password_confirmation');
        const passwordMatch = document.getElementById('passwordMatch');

        confirmPassword.addEventListener('input', function() {
            const password = passwordInput.value;
            const confirm = this.value;

            if (confirm.length > 0) {
                if (password !== confirm) {
                    this.classList.add('invalid');
                    this.classList.remove('valid');
                    passwordMatch.style.display = 'flex';
                } else {
                    this.classList.add('valid');
                    this.classList.remove('invalid');
                    passwordMatch.style.display = 'none';
                }
            } else {
                this.classList.remove('valid', 'invalid');
                passwordMatch.style.display = 'none';
            }
        });

        // Real-time email validation
        const emailInput = document.getElementById('email');
        emailInput.addEventListener('input', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email.length > 0) {
                if (emailRegex.test(email)) {
                    this.classList.add('valid');
                    this.classList.remove('invalid');
                } else {
                    this.classList.add('invalid');
                    this.classList.remove('valid');
                }
            } else {
                this.classList.remove('valid', 'invalid');
            }
        });

        // Form submission dengan AJAX
        const registerForm = document.getElementById('registerForm');
        const registerBtn = document.getElementById('registerBtn');
        const successPopup = document.getElementById('successPopup');
        const errorPopup = document.getElementById('errorPopup');
        const errorMessage = document.getElementById('errorMessage');

        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Tambahkan loading state
            registerBtn.classList.add('loading');
            registerBtn.textContent = 'Mendaftar...';
            registerBtn.disabled = true;

            // Siapkan data form
            const formData = new FormData(registerForm);

            // Kirim request AJAX
            fetch(registerForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                })
                .then(async response => {
                    const contentType = response.headers.get('content-type');

                    // Cek apakah response adalah JSON
                    if (contentType && contentType.includes('application/json')) {
                        const data = await response.json();

                        if (!response.ok) {
                            throw data;
                        }

                        return data;
                    } else {
                        // Jika bukan JSON, kemungkinan redirect atau HTML error page
                        if (response.ok) {
                            // Jika status OK tapi bukan JSON, anggap berhasil (redirect)
                            return {
                                success: true,
                                message: 'Registrasi berhasil!'
                            };
                        } else {
                            // Jika status tidak OK dan bukan JSON
                            throw new Error(`Server error: ${response.status} ${response.statusText}`);
                        }
                    }
                })
                .then(data => {
                    // Hapus loading state
                    registerBtn.classList.remove('loading');
                    registerBtn.textContent = 'Daftar Sekarang';
                    registerBtn.disabled = false;

                    // Tampilkan popup berhasil
                    showSuccessPopup();
                })
                .catch(async error => {
                    // Hapus loading state
                    registerBtn.classList.remove('loading');
                    registerBtn.textContent = 'Daftar Sekarang';
                    registerBtn.disabled = false;

                    console.error('Registration error:', error);

                    // Handle error validation
                    if (error.errors) {
                        // Tampilkan error validation
                        showValidationErrors(error.errors);
                    } else if (error.message) {
                        // Tampilkan error popup dengan pesan spesifik
                        showErrorPopup(error.message);
                    } else {
                        // Tampilkan error popup umum
                        showErrorPopup(
                            'Terjadi kesalahan saat mendaftar. Silakan periksa data Anda dan coba lagi.'
                            );
                    }
                });
        });

        function showValidationErrors(errors) {
            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(el => {
                if (!el.id) { // Jangan hapus error message yang sudah ada di HTML
                    el.remove();
                }
            });

            // Tampilkan error baru
            Object.keys(errors).forEach(field => {
                const input = document.getElementById(field);
                if (input) {
                    input.classList.add('invalid', 'shake');

                    // Buat error message
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message';
                    errorDiv.innerHTML = `<span>⚠️</span><small>${errors[field][0]}</small>`;

                    // Insert error message setelah input
                    input.parentNode.appendChild(errorDiv);

                    // Hapus shake animation setelah selesai
                    setTimeout(() => {
                        input.classList.remove('shake');
                    }, 500);
                }
            });
        }

        function showErrorPopup(message) {
            errorMessage.textContent = message;
            errorPopup.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeErrorPopup() {
            errorPopup.classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        function showSuccessPopup() {
            successPopup.classList.add('show');
            document.body.style.overflow = 'hidden';

            // Set auto-close timer
            setTimeout(() => {
                closePopup();
            }, 10000);
        }

        function closePopup() {
            successPopup.classList.remove('show');
            document.body.style.overflow = 'auto';

            // Reset form
            registerForm.reset();

            // Reset password strength bar
            strengthBar.className = 'password-strength-bar';
            strengthBar.style.width = '0%';

            // Remove validation classes
            inputs.forEach(input => {
                input.classList.remove('valid', 'invalid');
            });

            passwordMatch.style.display = 'none';

            // Clear custom error messages
            document.querySelectorAll('.error-message').forEach(el => {
                if (!el.id) {
                    el.remove();
                }
            });
        }

        function redirectToLogin() {
            window.location.href = "{{ route('login.form') }}";
        }

        // Close popup when clicking outside
        successPopup.addEventListener('click', function(e) {
            if (e.target === successPopup) {
                closePopup();
            }
        });

        errorPopup.addEventListener('click', function(e) {
            if (e.target === errorPopup) {
                closeErrorPopup();
            }
        });

        // Close popup with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (successPopup.classList.contains('show')) {
                    closePopup();
                }
                if (errorPopup.classList.contains('show')) {
                    closeErrorPopup();
                }
            }
        });
    </script>
</body>

</html>
