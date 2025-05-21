<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profil Pengguna</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f1f2f6;
      margin: 0;
      padding: 40px;
    }

    .profile-container {
      background: #ffffff;
      padding: 30px;
      border-radius: 10px;
      max-width: 600px;
      margin: auto;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    h1 {
      margin-bottom: 25px;
      color: #2f3542;
      font-size: 28px;
      text-align: center;
    }

    .info {
      font-size: 18px;
      margin-bottom: 15px;
      color: #57606f;
    }

    .info strong {
      color: #2f3542;
    }

    .edit-form {
      display: none;
      margin-top: 20px;
    }

    .edit-form input {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      margin-bottom: 15px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .buttons {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
    }

    button, a.button {
      background: #3742fa;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 5px;
      border: none;
      cursor: pointer;
      font-weight: bold;
    }

    button:hover, a.button:hover {
      background: #2f35d2;
    }

    .cancel-btn {
      background: #ced6e0;
      color: #2f3542;
    }

    .error {
      color: red;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="profile-container">
    <h1>👤 Profil Pengguna</h1>

    @if(session('success'))
      <div style="color: green; margin-bottom: 15px;">
        {{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div class="error">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="info"><strong>Nama:</strong> {{ Auth::user()->name }}</div>
    <div class="info"><strong>Email:</strong> {{ Auth::user()->email }}</div>

    <div class="buttons">
      <button onclick="toggleEdit()">✏️ Edit</button>
      <a href="/dashboard" class="button">⬅️ Dashboard</a>
    </div>

    <!-- Form edit (hidden awalnya) -->
    <form method="POST" action="{{ route('profile.update') }}" class="edit-form" id="editForm">
      @csrf

      <label>Nama</label>
      <input type="text" name="name" value="{{ Auth::user()->name }}" required>

      <label>Email</label>
      <input type="email" name="email" value="{{ Auth::user()->email }}" required>

      <label>Password Baru (opsional)</label>
      <input type="password" name="password">

      <label>Konfirmasi Password</label>
      <input type="password" name="password_confirmation">

      <div class="buttons">
        <button type="submit">💾 Simpan</button>
        <button type="button" onclick="toggleEdit()" class="cancel-btn">❌ Batal</button>
      </div>
    </form>
  </div>

  <script>
    function toggleEdit() {
      const form = document.getElementById('editForm');
      form.style.display = form.style.display === 'none' || form.style.display === '' ? 'block' : 'none';
    }
  </script>
</body>
</html>
