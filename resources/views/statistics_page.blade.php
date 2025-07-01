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
        .sidebar { width:280px; background:linear-gradient(145deg,#2c3e50,#34495e); color:white; padding:20px 0; position:fixed; left:0; top:0; height:100vh; transform:translateX(-100%); transition:transform 0.3s ease; z-index:1000; }
        .sidebar.active { transform:translateX(0); }
        .sidebar h2 { text-align:center; margin-bottom:30px; }
        .sidebar nav ul { list-style:none; }
        .sidebar nav ul li a,
        .sidebar nav ul li button { display:block; padding:15px 25px; text-decoration:none; color:white; background:none; border:none; cursor:pointer; text-align:left; }
        .sidebar nav ul li a:hover,
        .sidebar nav ul li button:hover { background:rgba(255,255,255,0.1); }
        .sidebar-overlay { position:fixed; top:0; left:0; width:100%; height:100vh; background:rgba(0,0,0,0.5); z-index:999; opacity:0; visibility:hidden; transition:all 0.3s ease; }
        .sidebar-overlay.active { opacity:1; visibility:visible; }
        .main-content { flex:1; margin-left:0; padding:20px; transition:margin-left 0.3s ease; }
        .main-content.sidebar-open { margin-left:280px; }
        header { background:white; padding:20px; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.05); margin-bottom:20px; }
        .header-top { display:flex; align-items:center; }
        .header-top h1 { margin:0; }
        .stats-section { background:white; padding:20px; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.05); margin-bottom:20px; }
        .stats-section h2 { margin-bottom:15px; }
        .stats-list li { margin-bottom:8px; }
        .chart-section { background:white; padding:20px; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.05); }
        @media(max-width:768px) {
            .main-content.sidebar-open { margin-left:0 }
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
            <canvas id="statChart" style="max-width:600px; margin:auto;"></canvas>
        </section>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let sidebarOpen = false;
    function toggleSidebar(){
        sidebarOpen = !sidebarOpen;
        document.getElementById('sidebar').classList.toggle('active',sidebarOpen);
        document.getElementById('sidebarOverlay').classList.toggle('active',sidebarOpen);
        document.getElementById('mainContent').classList.toggle('sidebar-open',sidebarOpen && window.innerWidth>768);
    }
    function confirmLogout(){
        if(confirm("Yakin mau logout?")) location.href="/logout";
    }

    const ctx = document.getElementById('statChart').getContext('2d');
    const statChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Belum Dikerjakan','Selesai','Terlambat'],
            datasets:[{
                data:[{{ $countNotDone }},{{ $countDone }},{{ $countLate }}],
                backgroundColor:['#6c757d','#28a745','#dc3545'],
                borderColor:'#fff',
                borderWidth:2
            }]
        },
        options:{
            responsive:true,
            plugins:{
                legend:{ position:'bottom' }
            }
        }
    });
</script>
</body>
</html>
