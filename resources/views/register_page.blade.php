<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register - To-Do App</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f6f8;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .register-container {
      background-color: white;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
    }

    .register-container h2 {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .form-group {
      margin-bottom: 1rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
    }

    .form-group input {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .error-text {
      color: red;
      font-size: 0.875rem;
      margin-top: 0.25rem;
    }

    .register-button {
      width: 100%;
      padding: 0.75rem;
      background-color: #28a745;
      border: none;
      color: white;
      font-weight: bold;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .register-button:hover {
      background-color: #218838;
    }

    .login-link {
      text-align: center;
      margin-top: 1rem;
    }

    .login-link a {
      color: #007bff;
      text-decoration: none;
    }

    .login-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="register-container">
    <h2>Daftar To-Do App</h2>
    <form action="{{ route('register') }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="name">Nama:</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        @error('name') <div class="error-text">{{ $message }}</div> @enderror
      </div>

      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        @error('email') <div class="error-text">{{ $message }}</div> @enderror
      </div>

      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        @error('password') <div class="error-text">{{ $message }}</div> @enderror
      </div>

      <div class="form-group">
        <label for="password_confirmation">Konfirmasi Password:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
      </div>

      <button class="register-button" type="submit">Daftar</button>
    </form>
    <div class="login-link">
      Sudah punya akun? <a href="{{ route('login.form') }}">Login di sini</a>
    </div>
  </div>
</body>
</html>
