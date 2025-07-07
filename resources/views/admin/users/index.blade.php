<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>📊 Kelola Pengguna</title>
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
        
        /* Improved User Management Section */
        .user-management-section {
            background:white;
            padding:25px;
            border-radius:12px;
            box-shadow:0 2px 10px rgba(0,0,0,0.08);
            margin-bottom:20px;
        }
        
        .user-management-section h2 {
            color:#2c3e50;
            font-size:1.3rem;
            margin-bottom:20px;
            padding-bottom:10px;
            border-bottom:1px solid #eee;
        }
        
        /* Form Styles */
        .user-form {
            background:#f9f9f9;
            padding:20px;
            border-radius:8px;
            margin-bottom:30px;
            border:1px solid #eee;
        }
        
        .user-form h3 {
            margin-bottom:15px;
            color:#2c3e50;
            font-size:1.1rem;
        }
        
        .form-grid {
            display:grid;
            grid-template-columns:repeat(auto-fill, minmax(200px, 1fr));
            gap:15px;
            margin-bottom:15px;
        }
        
        .form-actions {
            display:flex;
            gap:10px;
        }
        
        /* Table Styles */
        .users-table {
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }
        
        .users-table th {
            background-color:#f1f1f1;
            padding:12px 15px;
            text-align:left;
            font-weight:600;
            color:#2c3e50;
        }
        
        .users-table td {
            padding:12px 15px;
            border-bottom:1px solid #eee;
            color:#555;
        }
        
        .users-table tr:nth-child(even) {
            background-color:#fafafa;
        }
        
        .users-table tr:hover {
            background-color:#f0f8ff;
        }
        
        /* Action Buttons */
        .action-buttons {
            display:flex;
            gap:8px;
        }
        
        .btn {
            padding:6px 12px;
            border-radius:4px;
            font-size:0.85rem;
            cursor:pointer;
            transition:all 0.2s ease;
            text-decoration:none;
            display:inline-block;
        }
        
        .btn-edit {
            background:#007bff;
            color:white;
            border:1px solid #007bff;
        }
        
        .btn-edit:hover {
            background:#0069d9;
            border-color:#0062cc;
        }
        
        .btn-delete {
            background:#dc3545;
            color:white;
            border:1px solid #dc3545;
        }
        
        .btn-delete:hover {
            background:#c82333;
            border-color:#bd2130;
        }
        
        .btn-add {
            background:#28a745;
            color:white;
            border:1px solid #28a745;
            padding:8px 16px;
            margin-bottom:15px;
        }
        
        .btn-add:hover {
            background:#218838;
            border-color:#1e7e34;
        }
        
        /* Alert Messages */
        .alert {
            padding:12px 15px;
            border-radius:4px;
            margin-bottom:20px;
        }
        
        .alert-success {
            background:#d4edda;
            color:#155724;
            border:1px solid #c3e6cb;
        }
        
        .alert-danger {
            background:#f8d7da;
            color:#721c24;
            border:1px solid #f5c6cb;
        }
        
        /* Search Form */
        .search-form {
            display:flex;
            gap:10px;
            margin-left:auto;
        }
        
        .search-form input {
            padding:8px 12px;
            border:1px solid #ddd;
            border-radius:6px;
            min-width:250px;
        }
        
        .search-form button {
            background:#007bff;
            color:white;
            border:none;
            border-radius:6px;
            padding:8px 16px;
            cursor:pointer;
        }
        
        .search-form button:hover {
            background:#0069d9;
        }

        .add-user-form {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #e9ecef;
        }
        
        .add-user-form h3 {
            margin-top: 0;
            margin-bottom: 15px;
            color: #2c3e50;
            font-size: 1.1rem;
        }
        
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 10px;
            align-items: center;
        }
        
        .form-row input, 
        .form-row select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            flex: 1;
            min-width: 200px;
        }
        
        .form-row button {
            background: #28a745;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            white-space: nowrap;
        }
        
        .form-row button:hover {
            background: #218838;
        }
        
        /* Responsive Adjustments */
        @media(max-width:768px) {
            .main-content.sidebar-open { margin-left:0 }
            
            .form-grid {
                grid-template-columns:1fr;
            }
            
            .search-form {
                width:100%;
                margin-left:0;
                margin-top:15px;
            }
            
            .search-form input {
                min-width:0;
                flex:1;
            }
            
            .action-buttons {
                flex-direction:column;
                gap:5px;
            }
            
            .users-table {
                display:block;
                overflow-x:auto;
            }
        }
        
        @media(max-width:480px) {
            .main-content { padding:15px; }
            
            .header-top {
                flex-direction:column;
                align-items:flex-start;
            }
            
            .user-management-section {
                padding:15px;
            }
            
            .form-actions {
                flex-direction:column;
            }
            
            .btn {
                width:100%;
                text-align:center;
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
                @if(Auth::check() && Auth::user()->hasRole('admin'))
                    <li><a href="/admin/users">👥 Kelola Pengguna</a></li>
                    <li><a href="/admin/logs">🗂 Log Aktivitas</a></li>
                @endif
                <li><button onclick="confirmLogout()">🚪 Logout</button></li>
            </ul>
        </nav>
    </aside>
    <!-- main content -->
    <main class="main-content" id="mainContent">
        <header>
            <div class="header-top">
                <button class="burger-btn" onclick="toggleSidebar()">☰</button>
                <h1>📊 Kelola Pengguna</h1>
                <form method="GET" action="{{ route('admin.users.index') }}" class="search-form">
                    <input type="text" name="search" placeholder="Cari nama/email..." value="{{ request('search') }}">
                    <button type="submit">Cari</button>
                </form>
            </div>
        </header>

        <!-- User Management Section -->
        <section class="user-management-section">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Add User Form -->
            <div class="add-user-form">
                <h3>➕ Tambah Pengguna Baru</h3>
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    <div class="form-row">
                        <input type="text" name="name" placeholder="Nama" required>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-row">
                        <input type="password" name="password" placeholder="Password" required>
                        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
                    </div>
                    <div class="form-row">
                        <select name="role" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                        <button type="submit">Tambah Pengguna</button>
                    </div>
                </form>
            </div>

            <!-- Users Table -->
            <table class="users-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                    <tr>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->getRoleNames()->first() }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-edit">Edit</a>
                                @if($u->id != auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete">Hapus</button>
                                </form>
                                @else
                                <span style="color:#6c757d; font-size:0.85rem;">(Akun Anda)</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </main>
</div>

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