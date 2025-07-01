<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>📊 Statistik Tugas</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box }
        body { font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background:#f5f5f5 }
        .container { display:flex; min-height:100vh; }
        .burger-btn { background:#007bff; color:white; border:none; border-radius:8px; padding:10px 12px; cursor:pointer; margin-right:15px; }
        .burger-btn:hover { background:#0056b3 }
        .sidebar {
            width:280px;
            background:linear-gradient(145deg,#2c3e50,#34495e);
            color:white;
            padding:20px 0;
            position:fixed;
            left:0;
            top:0;
            height:100vh;
            transform:translateX(-100%);
            transition:transform 0.3s ease;
            z-index:1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar.active { transform:translateX(0); }
        .sidebar h2 { text-align:center; margin-bottom:30px; font-size:1.2rem; }
        .sidebar nav ul { list-style:none; }
        .sidebar nav ul li a,
        .sidebar nav ul li button {
            display:block;
            padding:15px 25px;
            text-decoration:none;
            color:white;
            background:none;
            border:none;
            cursor:pointer;
            text-align:left;
            width:100%;
            font-size:0.95rem;
            transition:background 0.2s ease;
        }
        .sidebar nav ul li a:hover,
        .sidebar nav ul li button:hover { background:rgba(255,255,255,0.15); }
        .sidebar-overlay {
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100vh;
            background:rgba(0,0,0,0.3);
            z-index:999;
            opacity:0;
            visibility:hidden;
            transition:all 0.3s ease;
        }
        .sidebar-overlay.active { opacity:1; visibility:visible; }
        .main-content {
            flex:1;
            margin-left:0;
            padding:20px;
            transition:margin-left 0.3s ease;
            background:#f5f5f5;
            min-height:100vh;
        }
        .main-content.sidebar-open { margin-left:280px; }
        header {
            background:white;
            padding:20px;
            border-radius:12px;
            box-shadow:0 2px 10px rgba(0,0,0,0.08);
            margin-bottom:20px;
        }
        .header-top { display:flex; align-items:center; }
        .header-top h1 { margin:0; color:#2c3e50; }
        .stats-section {
            background:white;
            padding:25px;
            border-radius:12px;
            box-shadow:0 2px 10px rgba(0,0,0,0.08);
            margin-bottom:20px;
        }
        .stats-section h2 {
            margin-bottom:20px;
            color:#2c3e50;
            font-size:1.3rem;
        }
        .stats-list {
            list-style:none;
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));
            gap:15px;
        }
        .stats-list li {
            background:#f8f9fa;
            padding:15px;
            border-radius:8px;
            border-left:4px solid #007bff;
            font-weight:500;
            color:#2c3e50;
        }
        .chart-section {
            background:white;
            padding:25px;
            border-radius:12px;
            box-shadow:0 2px 10px rgba(0,0,0,0.08);
        }
        .chart-section h2 {
            margin-bottom:25px;
            color:#2c3e50;
            font-size:1.3rem;
            text-align:center;
        }
        .chart-container {
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:400px;
        }
        #statChart {
            max-width:350px;
            max-height:350px;
        }

        /* Tasks Section */
        .tasks-section {
            background:white;
            padding:25px;
            border-radius:12px;
            box-shadow:0 2px 10px rgba(0,0,0,0.08);
            margin-top:20px;
        }
        .tasks-header {
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:25px;
            flex-wrap:wrap;
            gap:15px;
        }
        .tasks-header h2 {
            color:#2c3e50;
            font-size:1.3rem;
            margin:0;
        }
        .filter-controls {
            display:flex;
            gap:10px;
            flex-wrap:wrap;
        }
        .filter-controls select {
            padding:8px 12px;
            border:1px solid #ddd;
            border-radius:6px;
            background:white;
            font-size:0.9rem;
            cursor:pointer;
        }
        .filter-controls select:focus {
            outline:none;
            border-color:#007bff;
            box-shadow:0 0 0 2px rgba(0,123,255,0.25);
        }
        .tasks-grid {
            display:grid;
            gap:15px;
            margin-bottom:25px;
        }
        .task-item {
            border:1px solid #e9ecef;
            border-radius:8px;
            padding:20px;
            transition:all 0.2s ease;
            background:#fafafa;
        }
        .task-item:hover {
            box-shadow:0 4px 12px rgba(0,0,0,0.1);
            border-color:#007bff;
        }
        .task-header {
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            margin-bottom:12px;
            gap:15px;
        }
        .task-title {
            font-weight:600;
            color:#2c3e50;
            font-size:1.1rem;
            margin:0;
            flex:1;
        }
        .task-status {
            padding:4px 12px;
            border-radius:20px;
            font-size:0.8rem;
            font-weight:500;
            white-space:nowrap;
        }
        .status-pending {
            background:#6c757d;
            color:white;
        }
        .status-completed {
            background:#28a745;
            color:white;
        }
        .status-overdue {
            background:#dc3545;
            color:white;
        }
        .task-description {
            color:#6c757d;
            margin-bottom:12px;
            line-height:1.5;
        }
        .task-meta {
            display:flex;
            justify-content:space-between;
            align-items:center;
            font-size:0.9rem;
            color:#6c757d;
            flex-wrap:wrap;
            gap:10px;
        }
        .task-deadline {
            display:flex;
            align-items:center;
            gap:5px;
        }
        .task-created {
            display:flex;
            align-items:center;
            gap:5px;
        }

        /* Pagination */
        .pagination {
            display:flex;
            justify-content:center;
            align-items:center;
            gap:5px;
            flex-wrap:wrap;
        }
        .pagination-btn {
            padding:8px 12px;
            border:1px solid #ddd;
            background:white;
            color:#6c757d;
            text-decoration:none;
            border-radius:6px;
            cursor:pointer;
            transition:all 0.2s ease;
            font-size:0.9rem;
        }
        .pagination-btn:hover {
            background:#f8f9fa;
            border-color:#007bff;
            color:#007bff;
        }
        .pagination-btn.active {
            background:#007bff;
            border-color:#007bff;
            color:white;
        }
        .pagination-btn:disabled {
            opacity:0.5;
            cursor:not-allowed;
            pointer-events:none;
        }
        .pagination-info {
            margin:0 15px;
            color:#6c757d;
            font-size:0.9rem;
        }

        /* Empty State */
        .empty-state {
            text-align:center;
            padding:40px;
            color:#6c757d;
        }
        .empty-state i {
            font-size:3rem;
            margin-bottom:15px;
            display:block;
        }
        @media(max-width:768px) {
            .main-content.sidebar-open { margin-left:0 }
            .stats-list {
                grid-template-columns:1fr;
            }
            #statChart {
                max-width:280px;
                max-height:280px;
            }
            .chart-container {
                min-height:320px;
            }
            .tasks-header {
                flex-direction:column;
                align-items:flex-start;
            }
            .filter-controls {
                width:100%;
                justify-content:flex-start;
            }
            .filter-controls select {
                flex:1;
                min-width:120px;
            }
            .task-header {
                flex-direction:column;
                align-items:flex-start;
                gap:10px;
            }
            .task-meta {
                flex-direction:column;
                align-items:flex-start;
            }
        }
        @media(max-width:480px) {
            .main-content { padding:15px; }
            .stats-section, .chart-section { padding:20px; }
            #statChart {
                max-width:250px;
                max-height:250px;
            }
        }
    </style>
</head>
<body>
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
<div class="container">
    <!-- sidebar -->
    <aside class="sidebar" id="sidebar">
        <h2>Task Manager</h2>
        <nav>
            <ul>
                <li><a href="/">📋 Dashboard</a></li>
                <li><a href="/todolist/create">➕ Tambah Tugas</a></li>
                <li><a href="/statistic">📊 Statistik</a></li>
                <li><a href="/profile">👤 Profil</a></li>
                <li><button onclick="confirmLogout()">🚪 Logout</button></li>
            </ul>
        </nav>
    </aside>
    <!-- main content -->
    <main class="main-content" id="mainContent">
        <header>
            <div class="header-top">
                <button class="burger-btn" onclick="toggleSidebar()">☰</button>
                <h1>📊 Statistik Tugas</h1>
            </div>
        </header>

        <!-- statistik ringkas -->
        <section class="stats-section">
            <h2>Ringkasan</h2>
            <ul class="stats-list">
                <li>Total Tugas: {{ $countNotDone + $countDone + $countLate }}</li>
                <li>Belum Dikerjakan: {{ $countNotDone }}</li>
                <li>Selesai: {{ $countDone }}</li>
                <li>Terlambat: {{ $countLate }}</li>
            </ul>
        </section>

        <!-- chart -->
        <section class="chart-section">
            <h2>Grafik Tugas</h2>
            <div class="chart-container">
                <canvas id="statChart"></canvas>
            </div>
        </section>

        <!-- daftar tugas -->
        <section class="tasks-section">
            <div class="tasks-header">
                <h2>Daftar Tugas</h2>
                <div class="filter-controls">
                    <form method="GET" action="{{ route('statistic.index') }}">
                        <select name="status" onchange="this.form.submit()">
                            <option value="all" {{ request('status')=='all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="Not Done" {{ request('status')=='Not Done' ? 'selected' : '' }}>Belum Dikerjakan</option>
                            <option value="Done" {{ request('status')=='Done' ? 'selected' : '' }}>Selesai</option>
                            <option value="Late" {{ request('status')=='Late' ? 'selected' : '' }}>Terlambat</option>
                        </select>
                        <!-- contoh filter tanggal opsional -->
                        <!--
                <input type="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()">
                -->
                    </form>
                </div>
            </div>

            <div class="tasks-grid">
                @forelse ($tasks as $task)
                    <div class="task-item">
                        <div class="task-header">
                            <h3 class="task-title">{{ $task->task }}</h3>
                            <span class="task-status status-{{ Str::slug($task->status) }}">{{ $task->status }}</span>
                        </div>
                        <p class="task-description">{{ $task->description }}</p>
                        <div class="task-meta">
                            <div class="task-deadline">
                                <span>📅</span> Deadline: {{ \Carbon\Carbon::parse($task->deadline)->translatedFormat('l, d F Y') }}
                            </div>
                            <div class="task-created">
                                <span>🕐</span> Dibuat: {{ \Carbon\Carbon::parse($task->created_at)->translatedFormat('l, d F Y') }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i>📄</i>
                        <h3>Tidak ada tugas</h3>
                    </div>
                @endforelse
            </div>

            <div class="pagination">
                {{ $tasks->withQueryString()->links('pagination::simple-default') }}
            </div>

        </section>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    const ctx = document.getElementById('statChart').getContext('2d');
    const statChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Belum Dikerjakan','Selesai','Terlambat'],
            datasets:[{
                data:[{{ $countNotDone }},{{ $countDone }},{{ $countLate }}],
                backgroundColor:['#6c757d','#28a745','#dc3545'],
                borderColor:'#fff',
                borderWidth:3,
                hoverBorderWidth:4
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:true,
            plugins:{
                legend:{
                    position:'bottom',
                    labels: {
                        padding:20,
                        font: {
                            size:14
                        },
                        usePointStyle:true,
                        pointStyle:'circle'
                    }
                },
                tooltip: {
                    backgroundColor:'rgba(0,0,0,0.8)',
                    titleColor:'#fff',
                    bodyColor:'#fff',
                    borderColor:'#007bff',
                    borderWidth:1
                }
            },
            cutout:'65%',
            elements: {
                arc: {
                    borderRadius:5
                }
            }
        }
    });
</script>
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const main = document.getElementById('mainContent');

        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
        main.classList.toggle('sidebar-open');
    }

    function confirmLogout() {
        if (confirm('Yakin ingin logout?')) {
            window.location.href = '/logout';
        }
    }
</script>

</body>
</html>
