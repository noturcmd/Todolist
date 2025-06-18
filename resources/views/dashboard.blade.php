<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Tugas</title>

  @foreach($tasks as $task)
  <div class="task task-{{ $task->status }}">
    <h3>{{ $task->judul }}</h3>
    <p>Deadline: {{ $task->deadline }}</p>
  </div>
@endforeach

  <style>
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
        <div class="task task-todo">
          <h3>Belajar JavaScript</h3>
          <p>Deadline: 2025-05-25</p>
        </div>
        <div class="task task-inprogress">
          <h3>Desain UI Dashboard</h3>
          <p>Deadline: 2025-05-22</p>
        </div>
        <div class="task task-done">
          <h3>Setup Git Repository</h3>
          <p>Deadline: 2025-05-15</p>
        </div>
        <div class="task task-late">
          <h3>Kirim laporan mingguan</h3>
          <p>Deadline: 2025-05-10</p>
        </div>
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
          data: [1, 1, 1, 1],
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
