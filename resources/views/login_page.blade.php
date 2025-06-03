<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - To-Do App</title>
  <link rel="stylesheet" href="styles/login_page.css">
</head>
<body>
  <div class="login-container">
    <h2>Login To-Do App</h2>
    <form action="{{ route('login') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required />
        @error('email')
        <small style="color: red;">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required />
        @error('password')
        <small style="color: red;">{{ $message }}</small>
        @enderror
    </div>
    <button class="login-button" type="submit">Login</button>
    </form>

    <!-- <form action="/login" method="POST">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required />
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required />
      </div>
      <button class="login-button" type="submit">Login</button>
    </form> -->
    <div class="register-link">
      Belum punya akun? <a href="/register">Daftar di sini</a>
    </div>
  </div>
</body>
</html>
