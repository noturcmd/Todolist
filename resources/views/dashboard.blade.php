<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Dashboard Tugas</title>
    <style>
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

        /* Burger Menu Button - Now positioned in header */
        .burger-btn {
            background: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 12px;
            cursor: pointer;
            font-size: 18px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            margin-right: 15px;
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
            padding: 20px 0;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 1000;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
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
            background: rgba(255, 255, 255, 0.1);
            border-left-color: #3498db;
            transform: translateX(5px);
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
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
            position: relative;
        }

        .main-content.sidebar-open {
            margin-left: 280px;
        }

        /* Header */
        header {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            position: relative;
        }

        /* Header Top - Contains burger menu and title */
        .header-top {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .header-top h1 {
            color: #2c3e50;
            font-size: 28px;
            font-weight: 600;
            margin: 0;
        }

        /* Filters */
        .filters {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filters select,
        .filters input {
            padding: 10px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .filters select:focus,
        .filters input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }

        .search-box {
            min-width: 200px;
        }

        /* Task List */
        .task-list {
            display: grid;
            gap: 20px;
            margin-bottom: 30px;
        }

        .task {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-left: 5px solid #007bff;
            transition: all 0.3s ease;
        }

        .task:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .task-todo {
            border-left-color: #6c757d;
        }

        .task-done {
            border-left-color: #28a745;
            background: #f8fff9;
        }

        .task-late {
            border-left-color: #dc3545;
            background: #fff5f5;
        }

        .task h3 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 18px;
            font-weight: 600;
        }

        .task p {
            color: #6c757d;
            margin-bottom: 15px;
        }

        /* Status Buttons */
        .status-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .status-btn {
            padding: 8px 16px;
            border: 2px solid transparent;
            border-radius: 20px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        .status-btn.not-done {
            background: #6c757d;
            color: white;
        }

        .status-btn.done {
            background: #28a745;
            color: white;
        }

        .status-btn.late {
            background: #dc3545;
            color: white;
        }

        .status-btn.active {
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .status-btn:hover:not(.active) {
            opacity: 0.8;
            transform: translateY(-1px);
        }

        /* Chart Section */
        .chart-section {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .chart-section h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 22px;
            font-weight: 600;
        }

        /* Chart Container - Fixed Size */
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content.sidebar-open {
                margin-left: 0;
            }

            .filters {
                flex-direction: column;
                align-items: stretch;
            }

            .filters select,
            .filters input {
                width: 100%;
            }

            .status-buttons {
                justify-content: center;
            }

            /* Smaller chart on mobile */
            .chart-container {
                height: 250px;
                max-width: 350px;
            }
        }

        @media (min-width: 769px) {
            .sidebar-overlay {
                display: none;
            }
        }
    </style>
</head>
<body>
<!-- Sidebar Overlay for Mobile -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<div class="container">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <h2>Task Manager</h2>
        <nav>
            <ul>
                <li><a href="#">📋 Dashboard</a></li>
                <li><a href="#">➕ Tambah Tugas</a></li>
                <li><a href="#">📊 Statistik</a></li>
                <li><a href="/profile">👤 Profil</a></li>
                <li>
                    <button onclick="confirmLogout()">🚪 Logout</button>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main content -->
    <main class="main-content" id="mainContent">
        <header>
            <!-- Header Top Section with Burger Menu and Title -->
            <div class="header-top">
                <button class="burger-btn" onclick="toggleSidebar()">
                    <span id="burger-icon">☰</span>
                </button>
                <h1>📋 Dashboard Tugas</h1>
            </div>

            <!-- Filters Section -->
            <form method="GET" action="#" id="filterForm" class="filters">
                <select name="status" onchange="document.getElementById('filterForm').submit();">
                    <option value="all">Semua Status</option>
                    <option value="Not Done">Belum Dikerjakan</option>
                    <option value="Late">Lewat Deadline</option>
                    <option value="Done">Selesai</option>
                </select>

                <select name="deadline" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Semua Waktu</option>
                    <option value="today">Hari Ini</option>
                    <option value="week">Minggu Ini</option>
                    <option value="month">Bulan Ini</option>
                </select>

                <select name="sort" onchange="document.getElementById('filterForm').submit()">
                    <option value="latest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                    <option value="deadline_asc">Deadline Terdekat</option>
                    <option value="deadline_desc">Deadline Terjauh</option>
                </select>

                <input type="text" name="keyword" class="search-box" placeholder="Cari judul..."
                       oninput="delaySubmit()"/>
            </form>
        </header>

        <!-- Daftar tugas -->
        <section class="task-list">
            <!-- Sample Task 1 -->
            <div class="task task-todo">
                <h3>Menyelesaikan Laporan Bulanan</h3>
                <p>Deadline: 2025-07-05</p>

                <div class="status-buttons">
                    <form style="display: inline;">
                        <button type="button" class="status-btn not-done active">Belum</button>
                    </form>
                    <form style="display: inline;">
                        <button type="button" class="status-btn done">Selesai</button>
                    </form>
                    <form style="display: inline;">
                        <button type="button" class="status-btn late">Terlambat</button>
                    </form>
                </div>

                <div style="margin-top: 10px;">
                    <a href="#" style="margin-right:10px; color:blue; text-decoration:none;">✏️ Edit</a>
                    <button type="button" onclick="return confirm('Yakin ingin menghapus tugas ini?')"
                            style="color:red; background:none; border:none; cursor:pointer;">
                        🗑️ Hapus
                    </button>
                </div>
            </div>

            <!-- Sample Task 2 -->
            <div class="task task-done">
                <h3>Presentasi Project Q2</h3>
                <p>Deadline: 2025-06-28</p>

                <div class="status-buttons">
                    <form style="display: inline;">
                        <button type="button" class="status-btn not-done">Belum</button>
                    </form>
                    <form style="display: inline;">
                        <button type="button" class="status-btn done active">Selesai</button>
                    </form>
                    <form style="display: inline;">
                        <button type="button" class="status-btn late">Terlambat</button>
                    </form>
                </div>

                <div style="margin-top: 10px;">
                    <a href="#" style="margin-right:10px; color:blue; text-decoration:none;">✏️ Edit</a>
                    <button type="button" onclick="return confirm('Yakin ingin menghapus tugas ini?')"
                            style="color:red; background:none; border:none; cursor:pointer;">
                        🗑️ Hapus
                    </button>
                </div>
            </div>

            <!-- Sample Task 3 -->
            <div class="task task-late">
                <h3>Review Dokumen Legal</h3>
                <p>Deadline: 2025-06-25</p>

                <div class="status-buttons">
                    <form style="display: inline;">
                        <button type="button" class="status-btn not-done">Belum</button>
                    </form>
                    <form style="display: inline;">
                        <button type="button" class="status-btn done">Selesai</button>
                    </form>
                    <form style="display: inline;">
                        <button type="button" class="status-btn late active">Terlambat</button>
                    </form>
                </div>

                <div style="margin-top: 10px;">
                    <a href="#" style="margin-right:10px; color:blue; text-decoration:none;">✏️ Edit</a>
                    <button type="button" onclick="return confirm('Yakin ingin menghapus tugas ini?')"
                            style="color:red; background:none; border:none; cursor:pointer;">
                        🗑️ Hapus
                    </button>
                </div>
            </div>
        </section>

        <!-- Chart tugas -->
        <section class="chart-section">
            <h2>📊 Ringkasan Tugas</h2>
            <div class="chart-container">
                <canvas id="taskChart"></canvas>
            </div>
        </section>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart Configuration
    const ctx = document.getElementById('taskChart').getContext('2d');

    const taskChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Belum Dikerjakan', 'Selesai', 'Lewat Deadline'],
            datasets: [{
                label: 'Status Tugas',
                data: [1, 1, 1],
                backgroundColor: ['#6c757d', '#28a745', '#dc3545'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1.5,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });

    // Logout confirmation function
    function confirmLogout() {
        const result = confirm('Apakah Anda yakin ingin logout?');
        if (result) {
            // Redirect to logout URL
            window.location.href = '/logout';
        }
    }

    // Sidebar Toggle Functionality
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
    window.addEventListener('resize', function () {
        const mainContent = document.getElementById('mainContent');

        if (window.innerWidth <= 768) {
            mainContent.classList.remove('sidebar-open');
        } else if (sidebarOpen) {
            mainContent.classList.add('sidebar-open');
        }
    });

    // Search delay functionality
    let typingTimer;
    const doneTypingInterval = 500;

    function delaySubmit() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, doneTypingInterval);
    }

    // Status button functionality
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('status-btn')) {
            const taskElement = e.target.closest('.task');
            const statusButtons = taskElement.querySelectorAll('.status-btn');

            // Remove active class from all buttons in this task
            statusButtons.forEach(btn => btn.classList.remove('active'));

            // Add active class to clicked button
            e.target.classList.add('active');

            // Update task styling based on status
            taskElement.classList.remove('task-todo', 'task-done', 'task-late');

            if (e.target.classList.contains('not-done')) {
                taskElement.classList.add('task-todo');
            } else if (e.target.classList.contains('done')) {
                taskElement.classList.add('task-done');
            } else if (e.target.classList.contains('late')) {
                taskElement.classList.add('task-late');
            }
        }
    });

    // Function to get cookie value
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
        return null;
    }

    // Check if user is logged in - SEMENTARA DINONAKTIFKAN UNTUK TESTING
    window.onload = function() {
        console.log("=== DEBUGGING COOKIES ===");
        console.log("Current URL:", window.location.href);
        console.log("All cookies:", document.cookie);

        // Coba berbagai kemungkinan nama cookie
        const possibleNames = ['user_email', 'userEmail', 'email', 'user', 'login_email'];

        possibleNames.forEach(name => {
            const value = getCookie(name);
            console.log(`Cookie '${name}':`, value);
        });

        // Untuk sementara, NONAKTIFKAN popup agar bisa debug
        console.log("POPUP DINONAKTIFKAN UNTUK DEBUGGING");
        console.log("Silakan cek console dan beri tahu hasil cookie apa yang muncul");

        // UNCOMMENT baris di bawah setelah tahu cookie mana yang benar
        /*
        const userEmail = getCookie("user_email");
        if (!userEmail || userEmail.trim() === '') {
            showPopup();
        }
        */
    };

    // Function to show the popup
    function showPopup() {
        const popup = confirm('You are not logged in. You will be redirected to the login page.');
        if (popup) {
            // Redirect to login page
            window.location.href = '/login';
        } else {
            // If user clicks Cancel, redirect anyway for security
            window.location.href = '/login';
        }
    }
</script>

</body>
</html>
