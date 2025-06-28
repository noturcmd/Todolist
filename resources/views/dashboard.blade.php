<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Tugas</title>


  <style>
    .task-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.task-title {
  font-size: 18px;
  font-weight: bold;
  margin-right: 10px;
}

.task-actions a.btn-edit,
.task-actions button.btn-delete {
  display: inline-block;
  padding: 6px 12px;
  margin-left: 5px;
  font-size: 14px;
  border: none;
  border-radius: 5px;
  text-decoration: none;
  cursor: pointer;
}

.task-actions a.btn-edit {
  background-color: #007bff;
  color: white;
}

.task-actions button.btn-delete {
  background-color: #dc3545;
  color: white;
}

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      display: flex;
      height: 100vh;
    }

    .container {
      display: flex;
      width: 100%;
    }

    .sidebar {
      width: 250px;
      background: #f5f6fa;
      padding: 20px;
      border-right: 1px solid #ddd;
    }

    .sidebar h2 {
      margin-bottom: 20px;
      color: #333;
    }

    .sidebar ul {
      list-style: none;
    }

    .sidebar li {
      margin: 15px 0;
    }

    .sidebar a {
      text-decoration: none;
      color: #333;
    }

    .main-content {
      flex: 1;
      padding: 20px;
      background: #fff;
      overflow-y: auto;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .filters select {
      margin-left: 10px;
      padding: 5px;
    }

    .task-list {
      margin-top: 20px;
      display: grid;
      gap: 15px;
    }

    .task {
      padding: 15px;
      border-radius: 10px;
      background: #f0f0f0;
    }

    .task-todo {
      border-left: 6px solid gray;
    }
    .task-inprogress {
      border-left: 6px solid #007bff;
    }
    .task-done {
      border-left: 6px solid #28a745;
    }
    .task-late {
      border-left: 6px solid #dc3545;
    }

    .chart-section {
      margin-top: 40px;
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h2>Task Manager</h2>
      <nav>
        <ul>
          <li><a href="#">📋 Dashboard</a></li>
          <li><a href="{{ route('todolist.create') }}">➕ Tambah Tugas</a></li>
          <li><a href="#">📊 Statistik</a></li>
          <li><a href="{{ route('profile') }}">👤 Profil</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Main content -->
    <main class="main-content">
      <header>
        <h1>📋 Dashboard Tugas</h1>
        <div class="filters">
          <select id="filter-status">
            <option value="all">Semua Status</option>
            <option value="todo">Belum Dikerjakan</option>
            <option value="inprogress">Sedang Dikerjakan</option>
            <option value="done">Selesai</option>
            <option value="late">Lewat Deadline</option>
          </select>
          <select id="filter-time">
            <option value="all">Semua Waktu</option>
            <option value="today">Hari Ini</option>
            <option value="week">1 Minggu</option>
            <option value="month">1 Bulan</option>
          </select>
        </div>
      </header>

<!-- Daftar tugas -->
<section class="task-list">
  @forelse($tasks as $task)
    <div class="task 
      {{ $task->status == 'Not Done' ? 'task-todo' : '' }}
      {{ $task->status == 'Done' ? 'task-done' : '' }}
      {{ $task->status == 'Late' ? 'task-late' : '' }}">
      
      <div class="task-header">
        <h3 class="task-title">{{ $task->task }}</h3>
        <div class="task-actions">
          <a href="{{ route('todolist.edit', $task->id) }}" class="btn-edit">✏️ Edit</a>

          <form action="{{ route('todolist.destroy', $task->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Yakin ingin menghapus tugas ini?')" class="btn-delete">
              🗑️ Hapus
            </button>
          </form>
        </div>
      </div>

      <p>Deadline: {{ $task->deadline }}</p>
    </div>
  @empty
    <p>Tidak ada tugas ditemukan.</p>
  @endforelse
</section>
</section>

      <!-- Chart tugas -->
      <section class="chart-section">
        <h2>📊 Ringkasan Tugas</h2>
        <canvas id="taskChart" width="400" height="200"></canvas>
      </section>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('taskChart').getContext('2d');

    const taskChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Belum Dikerjakan', 'Sedang Dikerjakan', 'Selesai', 'Lewat Deadline'],
        datasets: [{
          label: 'Status Tugas',
          data: [{{ $countNotDone }}, 0, {{ $countDone }}, {{ $countLate }}],
          backgroundColor: ['gray', '#007bff', '#28a745', '#dc3545'],
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'bottom',
          }
        }
      }
    });
  </script>
</body>
</html>
