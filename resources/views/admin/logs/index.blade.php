<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Aktivitas</title>
    <style>
        .log-container {
            max-width: 1000px;
            margin: 80px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .log-container h1 {
            margin-bottom: 25px;
            color: #2c3e50;
            font-size: 28px;
            text-align: center;
        }

        .log-search {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .log-search input {
            padding: 10px 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            width: 250px;
        }

        .log-search button {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .log-search button:hover {
            background: #0056b3;
        }

        .log-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .log-table th, .log-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .log-table th {
            background: #f8f9fa;
            color: #333;
        }

        .log-table tr:hover {
            background: #f1f1f1;
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
        }

      * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Burger Menu Button */
        .burger-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px;
            cursor: pointer;
            font-size: 18px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .burger-btn:hover {
            background: #0056b3;
            transform: scale(1.05);
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background: linear-gradient(145deg, #2c3e50, #34495e);
            color: white;
            padding: 80px 0 20px 0;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 1000;
            box-shadow: 2px 0 15px rgba(0,0,0,0.1);
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: 600;
            color: #ecf0f1;
        }

        .sidebar nav ul {
            list-style: none;
        }

        .sidebar nav ul li {
            margin: 0;
        }

        .sidebar nav ul li a,
        .sidebar nav ul li button {
            display: block;
            padding: 15px 25px;
            text-decoration: none;
            color: #ecf0f1;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .sidebar nav ul li a:hover,
        .sidebar nav ul li button:hover {
            background: rgba(255,255,255,0.1);
            border-left-color: #3498db;
            transform: translateX(5px);
        }

        .sidebar nav ul li a.active {
            background: rgba(255,255,255,0.2);
            border-left-color: #3498db;
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 20px;
            margin-left: 0;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-content.sidebar-open {
            margin-left: 280px;
        }

        /* Profile Container */
        .profile-container {
            background: #ffffff;
            padding: 40px;
            border-radius: 15px;
            max-width: 700px;
            width: 100%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-top: 60px;
        }

        h1 {
            margin-bottom: 30px;
            color: #2c3e50;
            font-size: 32px;
            text-align: center;
            font-weight: 600;
        }

        .info {
            font-size: 18px;
            margin-bottom: 20px;
            color: #6c757d;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #007bff;
        }

        .info strong {
            color: #2c3e50;
            display: inline-block;
            min-width: 80px;
        }

        .edit-form {
            display: none;
            margin-top: 30px;
            padding: 25px;
            background: #f8f9fa;
            border-radius: 10px;
            border: 1px solid #e9ecef;
        }

        .edit-form label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 500;
            font-size: 14px;
        }

        .edit-form input {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .edit-form input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        button, a.button {
            background: #007bff;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        button:hover, a.button:hover {
            background: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,123,255,0.3);
        }

        .cancel-btn {
            background: #6c757d;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .cancel-btn:hover {
            background: #5a6268;
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }

        .error ul {
            margin: 0;
            padding-left: 20px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content.sidebar-open {
                margin-left: 0;
            }

            .profile-container {
                margin: 80px 10px 20px 10px;
                padding: 25px;
            }

            .buttons {
                flex-direction: column;
            }

            button, a.button {
                width: 100%;
                justify-content: center;
            }

            h1 {
                font-size: 24px;
            }

            .info {
                font-size: 16px;
            }
        }

        @media (min-width: 769px) {
            .sidebar-overlay {
                display: none;
            }
        }

        .pagination svg {
    width: 16px;
    height: 16px;
}


    </style>
    <!-- Burger Menu Button -->
    <button class="burger-btn" onclick="toggleSidebar()">
        <span id="burger-icon">☰</span>
    </button>

<!-- Sidebar Overlay for Mobile -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<div class="container">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <h2>Task Manager</h2>
        <nav>
            <ul>
                <li><a href="/">📋 Dashboard</a></li>
                <li><a href="/todolist/create">➕ Tambah Tugas</a></li>
                <li><a href="/statistic">📊 Statistik</a></li>
                <li><a href="/profile">👤 Profil</a></li>
                @if(Auth::check() && Auth::user()->hasRole('admin'))
                    <li><a href="/admin/users">👥 Kelola Pengguna</a></li>
                    <li><a href="/admin/logs">🗂 Log Aktivitas</a></li>
                @endif
                <li><button onclick="confirmLogout()">🚪 Logout</button></li>
            </ul>
        </nav>
    </aside>

    <!-- Main content -->
    <main class="main-content" id="mainContent">
       
<div class="log-container">
    <h1>🗂 Log Aktivitas</h1>
    <!-- Success Message -->
    @if(session('success'))
        <div class="success-message" style="display: block;" id="successMessage">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Messages -->
    <div class="error" style="display: none;" id="errorMessage">
        <ul>
            <li>Terjadi kesalahan saat memperbarui profil</li>
        </ul>
    </div>
    <div class="log-search">
        <form method="GET" action="{{ route('admin.logs.index') }}">
            <input type="text" name="search" placeholder="Cari aktivitas..." value="{{ request('search') }}">
            <button type="submit">🔍 Cari</button>
        </form>
    </div>

    <div class="log-table">
        <table>
            <thead>
                <tr>
                    <th>🧑 Pengguna</th>
                    <th>🕒 Waktu</th>
                    <th>📄 Aktivitas</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td>{{ $log->user->name ?? 'System' }}</td>
                    <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                    <td>{{ $log->activity }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">Tidak ada log aktivitas ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $logs->links() }}
    </div>
</div>

    </main>
</div>

<script>
    @if(session('success'))
    alert("{{ session('success') }}");
    @endif
</script>

<script>
    // Sidebar Toggle Functionality (sama dengan yang ada di dashboard)
    let sidebarOpen = false;

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const overlay = document.getElementById('sidebarOverlay');
        const burgerIcon = document.getElementById('burger-icon');

        sidebarOpen = !sidebarOpen;

        if (sidebarOpen) {
            sidebar.classList.add('active');
            overlay.classList.add('active');
            burgerIcon.innerHTML = '✕';

            // Only add margin on desktop
            if (window.innerWidth > 768) {
                mainContent.classList.add('sidebar-open');
            }
        } else {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            mainContent.classList.remove('sidebar-open');
            burgerIcon.innerHTML = '☰';
        }
    }

    // Handle window resize
    window.addEventListener('resize', function() {
        const mainContent = document.getElementById('mainContent');

        if (window.innerWidth <= 768) {
            mainContent.classList.remove('sidebar-open');
        } else if (sidebarOpen) {
            mainContent.classList.add('sidebar-open');
        }
    });

    // Edit Form Toggle
    function toggleEdit() {
        const form = document.getElementById('editForm');
        const isVisible = form.style.display === 'block';

        form.style.display = isVisible ? 'none' : 'block';

        // Smooth scroll to form when showing
        if (!isVisible) {
            setTimeout(() => {
                form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }, 100);
        }
    }

    // Logout function
    function logout() {
        if (confirm('Yakin ingin logout?')) {
            alert('Logout berhasil!');
            // Implement actual logout logic here
        }
    }
</script>
</body>
</html>
