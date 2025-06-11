<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tambah Tugas</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f5f6fa;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .form-container {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      width: 400px;
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #333;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    input, select, textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
    }

    button {
      width: 100%;
      background-color: #007bff;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background-color: #0056b3;
    }

    .back-link {
      display: block;
      margin-top: 15px;
      text-align: center;
      color: #007bff;
      text-decoration: none;
    }

    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>➕ Tambah Tugas Baru</h2>
    <form action="{{ route('todolist.store') }}" method="POST">
      @csrf
      <label for="judul">Judul Tugas</label>
      <input type="text" id="judul" name="judul" required>

      <label for="deskripsi">Deskripsi</label>
      <textarea id="deskripsi" name="deskripsi" rows="4"></textarea>

      <label for="status">Status</label>
      <select id="status" name="status" required>
        <option value="todo">Belum Dikerjakan</option>
        <option value="inprogress">Sedang Dikerjakan</option>
        <option value="done">Selesai</option>
        <option value="late">Lewat Deadline</option>
      </select>

      <label for="deadline">Deadline</label>
      <input type="date" id="deadline" name="deadline" required>

      <button type="submit">Simpan Tugas</button>
    </form>

    <a href="{{ route('dashboard') }}" class="back-link">← Kembali ke Dashboard</a>
  </div>
</body>
</html>
