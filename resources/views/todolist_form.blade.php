<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>{{ isset($task) ? 'Edit Tugas' : 'Tambah Tugas' }}</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f0f0f0;
      padding: 40px;
    }
    .container {
      max-width: 600px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }
    label {
      font-weight: bold;
      display: block;
      margin-top: 15px;
    }
    input, textarea, select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    .btn {
      margin-top: 20px;
      background-color: #007bff;
      color: white;
      padding: 10px;
      width: 100%;
      border: none;
      border-radius: 8px;
      font-size: 16px;
    }
    .btn:hover {
      background-color: #0056b3;
    }
    .actions {
      margin-top: 20px;
      text-align: center;
    }
    .actions a, .actions form {
      display: inline-block;
      margin: 0 10px;
    }
    .btn-secondary {
      background-color: #6c757d;
    }
    .btn-danger {
      background-color: #dc3545;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>{{ isset($task) ? '✏️ Edit Tugas' : '➕ Tambah Tugas' }}</h2>

    <form 
      action="{{ isset($task) ? route('todolist.update', $task->id) : route('todolist.store') }}" 
      method="POST">
      @csrf
      @if(isset($task))
        @method('PUT')
      @endif

      <label>Judul Tugas</label>
      <input type="text" name="task" value="{{ $task->task ?? old('task') }}" {{ isset($readonly) ? 'readonly' : 'required' }}>

      <label>Deskripsi</label>
      <textarea name="description" rows="4" {{ isset($readonly) ? 'readonly' : '' }}>{{ $task->description ?? old('description') }}</textarea>

      <label>Status</label>
      <select name="status" {{ isset($readonly) ? 'disabled' : '' }}>
        <option value="Not Done" {{ (isset($task) && $task->status == 'Not Done') ? 'selected' : '' }}>Belum Dikerjakan</option>
        <option value="Done" {{ (isset($task) && $task->status == 'Done') ? 'selected' : '' }}>Selesai</option>
        <option value="Late" {{ (isset($task) && $task->status == 'Late') ? 'selected' : '' }}>Lewat Deadline</option>
      </select>

      <label>Deadline</label>
      <input type="date" name="deadline" value="{{ $task->deadline ?? old('deadline') }}" {{ isset($readonly) ? 'readonly' : 'required' }}>

      @if(!isset($readonly))
        <button type="submit" class="btn">💾 Simpan</button>
      @endif
    </form>

    <div class="actions">
      @if(isset($task) && isset($readonly))
        <a href="{{ route('todolist.edit', $task->id) }}" class="btn btn-secondary">✏️ Edit</a>
        <form action="{{ route('todolist.destroy', $task->id) }}" method="POST" style="display:inline">
          @csrf
          @method('DELETE')
          <button class="btn btn-danger" onclick="return confirm('Hapus tugas ini?')">🗑️ Hapus</button>
        </form>
      @endif

      <br><br>
      <a href="{{ route('dashboard') }}" class="btn btn-secondary">← Kembali</a>
    </div>
  </div>
</body>
</html>
