<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Task Manager')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .task-status {
            padding: 5px 12px;
            border-radius: 12px;
            font-size: 0.8rem;
        }
        .task-status.Not\ Done { background-color: #6c757d; color: #fff; }
        .task-status.Done { background-color: #28a745; color: #fff; }
        .task-status.Late { background-color: #dc3545; color: #fff; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="/">📋 Task Manager</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample"
                aria-controls="navbarsExample" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsExample">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="/statistics">Statistik</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/profile">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout" onclick="return confirm('Yakin logout?')">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mb-5">
    @yield('content')
</div>
<footer class="text-center text-muted small py-4 border-top">
    &copy; {{ date('Y') }} Task Manager
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
