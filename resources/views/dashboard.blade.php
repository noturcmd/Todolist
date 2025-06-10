<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Tugas</title>
  <link rel="stylesheet" href="styles/dashboard.css">
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h2>Task Manager</h2>
      <nav>
        <ul>
          <li><a href="#">📋 Dashboard</a></li>
          <li><a href="#">➕ Tambah Tugas</a></li>
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
