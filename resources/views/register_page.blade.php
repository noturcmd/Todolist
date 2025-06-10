<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register - To-Do App</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="styles/register_page.css">
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
