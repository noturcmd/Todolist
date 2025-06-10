<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profil Pengguna</title>
  <link rel="stylesheet" href="styles/profile_page.css">
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
