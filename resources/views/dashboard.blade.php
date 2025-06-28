<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Tugas</title>


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

    .sidebar form button {
      background: none;
      border: none;
      color: #333;
      cursor: pointer;
      padding: 0;
      font: inherit;
      text-align: left;
    }
    .sidebar form button:hover {
      text-decoration: underline;
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
    .search-box {
      padding: 5px 10px;
      width: 250px;
      border: 1px solid #ccc;
      border-radius: 5px;
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
          <li>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
              @csrf
              <button type="submit" style="background:none; border:none; color:#333; cursor:pointer;">🚪 Logout</button>
            </form>
          </li>

        </ul>
      </nav>
    </aside>

    <!-- Main content -->
    <main class="main-content">
      <header>
        <h1>📋 Dashboard Tugas</h1>
        <form method="GET" action="{{ route('dashboard') }}" id="filterForm" class="filters">
       <select name="status" onchange="document.getElementById('filterForm').submit();">
        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
        <option value="Not Done" {{ request('status') == 'Not Done' ? 'selected' : '' }}>Belum Dikerjakan</option>
        <option value="Late" {{ request('status') == 'Late' ? 'selected' : '' }}>Lewat Deadline</option>
        <option value="Done" {{ request('status') == 'Done' ? 'selected' : '' }}>Selesai</option>
      </select>

        <select name="deadline" onchange="document.getElementById('filterForm').submit()">
          <option value="">Semua Waktu</option>
          <option value="today" {{ request('deadline') == 'today' ? 'selected' : '' }}>Hari Ini</option>
          <option value="week" {{ request('deadline') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
          <option value="month" {{ request('deadline') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
        </select>

        <select name="sort" onchange="document.getElementById('filterForm').submit()">
          <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
          <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
          <option value="deadline_asc" {{ request('sort') == 'deadline_asc' ? 'selected' : '' }}>Deadline Terdekat</option>
          <option value="deadline_desc" {{ request('sort') == 'deadline_desc' ? 'selected' : '' }}>Deadline Terjauh</option>
        </select>

        <input type="text" name="keyword" class="search-box" placeholder="Cari judul..." value="{{ request('keyword') }}" oninput="delaySubmit()" />
      </form>


      </header>

<!-- Daftar tugas -->
<section class="task-list">
  @forelse($tasks as $task)
    <div class="task 
      {{ $task->status == 'Not Done' ? 'task-todo' : '' }}
      {{ $task->status == 'Done' ? 'task-done' : '' }}
      {{ $task->status == 'Late' ? 'task-late' : '' }}">
      
      <h3>{{ $task->task }}</h3>
      <p>Deadline: {{ $task->deadline }}</p>

      <!-- Tombol Aksi -->
      <div style="margin-top: 10px;">
        <a href="{{ route('todolist.edit', $task->id) }}" style="margin-right:10px; color:blue; text-decoration:none;">✏️ Edit</a>

        <form action="{{ route('todolist.destroy', $task->id) }}" method="POST" style="display:inline;">
          @csrf
          @method('DELETE')
          <button type="submit" onclick="return confirm('Yakin ingin menghapus tugas ini?')" style="color:red; background:none; border:none; cursor:pointer;">
            🗑️ Hapus
          </button>
        </form>
      </div>
    </div>
  @empty
    <p>Tidak ada tugas ditemukan.</p>
  @endforelse
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

  <script>
    let typingTimer;
    const doneTypingInterval = 500; // 0.5 detik

    function delaySubmit() {
      clearTimeout(typingTimer);
      typingTimer = setTimeout(() => {
        document.getElementById('filterForm').submit();
      }, doneTypingInterval);
    }
  </script>

</body>
</html>
