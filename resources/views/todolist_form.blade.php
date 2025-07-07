<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ isset($task) ? 'Edit Tugas' : 'Tambah Tugas' }}</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f5f6fa;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .form-container {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      width: 400px;
    }
    input, textarea, select {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }
    button {
      width: 100%;
      background-color: #007bff;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }
    a.back-link {
      display: block;
      text-align: center;
      margin-top: 15px;
      color: #007bff;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>{{ isset($task) ? '✏️ Edit Tugas' : '➕ Tambah Tugas' }}</h2>

    <form action="{{ isset($task) ? route('todolist.update', $task->id) : route('todolist.store') }}" method="POST">
      @csrf
      @if(isset($task))
        @method('PUT')
      @endif

      <label for="task">Judul Tugas</label>
      <input type="text" id="task" name="task" value="{{ old('task', $task->task ?? '') }}" required>

      <label for="description">Deskripsi</label>
      <textarea id="description" name="description">{{ old('description', $task->description ?? '') }}</textarea>

      <label for="status">Status</label>
      <select id="status" name="status" required>
        <option value="Not Done" {{ (isset($task) && $task->status == 'Not Done') ? 'selected' : '' }}>Belum Dikerjakan</option>
        <option value="Done" {{ (isset($task) && $task->status == 'Done') ? 'selected' : '' }}>Selesai</option>
        <option value="Late" {{ (isset($task) && $task->status == 'Late') ? 'selected' : '' }}>Lewat Deadline</option>
      </select>

      <label for="deadline">Deadline</label>
      <input type="date" id="deadline" name="deadline" value="{{ old('deadline', isset($task) ? \Carbon\Carbon::parse($task->deadline)->format('Y-m-d') : '') }}" required>

      <button type="submit">{{ isset($task) ? '💾 Update Tugas' : 'Simpan Tugas' }}</button>
    </form>

    <a href="{{ route('dashboard') }}" class="back-link">← Kembali ke Dashboard</a>
  </div>
</body>
</html>
