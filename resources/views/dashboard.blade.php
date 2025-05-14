<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Todolist</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen p-6">

  <header class="mb-6">
    <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">📋 Dashboard Todolist</h1>
    <p class="text-sm text-gray-500 mt-1">Pantau dan kelola semua tugasmu di satu tempat</p>
  </header>

  <!-- Filter -->
  <div class="mb-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-2">
    <label for="filterWaktu" class="text-sm font-medium">Filter berdasarkan waktu:</label>
    <select id="filterWaktu" class="p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
      <option value="today">Hari Ini</option>
      <option value="tomorrow">Besok</option>
      <option value="1week">1 Minggu</option>
      <option value="1month">1 Bulan</option>
    </select>
  </div>

  <!-- Ringkasan -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @php
      $summary = [
        ['label' => 'Belum Dikerjakan', 'count' => 5, 'color' => 'bg-gray-100 text-gray-800'],
        ['label' => 'Sedang Dikerjakan', 'count' => 3, 'color' => 'bg-blue-100 text-blue-800'],
        ['label' => 'Selesai', 'count' => 8, 'color' => 'bg-green-100 text-green-800'],
        ['label' => 'Lewat Deadline', 'count' => 2, 'color' => 'bg-red-100 text-red-800'],
      ];
    @endphp

    @foreach ($summary as $item)
      <div class="rounded-xl p-5 shadow-sm hover:shadow-md transition-all duration-200 {{ $item['color'] }}">
        <h2 class="text-sm uppercase tracking-wide font-semibold">{{ $item['label'] }}</h2>
        <p class="text-3xl font-bold mt-1">{{ $item['count'] }}</p>
      </div>
    @endforeach
  </div>

  <!-- Chart -->
  <div class="bg-white rounded-xl shadow p-6 mb-6">
    <h2 class="text-xl font-semibold mb-4">📊 Statistik Tugas</h2>
    <canvas id="taskChart"></canvas>
  </div>

  <!-- Tabel Tugas -->
  <div class="bg-white rounded-xl shadow p-6">
    <h2 class="text-xl font-semibold mb-4">📌 Daftar Tugas</h2>
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
        <thead>
          <tr class="bg-gray-100 text-left">
            <th class="px-4 py-2">Nama Tugas</th>
            <th class="px-4 py-2">Rincian</th>
            <th class="px-4 py-2">Deadline</th>
            <th class="px-4 py-2">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-2 font-medium">Membuat desain UI</td>
            <td class="px-4 py-2">Desain tampilan dashboard</td>
            <td class="px-4 py-2">2025-05-15</td>
            <td class="px-4 py-2 text-blue-600 font-semibold">Sedang Dikerjakan</td>
          </tr>
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-2 font-medium">Meeting dengan tim</td>
            <td class="px-4 py-2">Bahas progress tugas</td>
            <td class="px-4 py-2">2025-05-12</td>
            <td class="px-4 py-2 text-green-600 font-semibold">Selesai</td>
          </tr>
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-2 font-medium">Update backend API</td>
            <td class="px-4 py-2">Tambahkan filter status</td>
            <td class="px-4 py-2">2025-05-10</td>
            <td class="px-4 py-2 text-red-600 font-semibold">Lewat Deadline</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    const ctx = document.getElementById('taskChart').getContext('2d');
    const taskChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Belum Dikerjakan', 'Sedang Dikerjakan', 'Selesai', 'Lewat Deadline'],
        datasets: [{
          label: 'Jumlah Tugas',
          data: [5, 3, 8, 2],
          backgroundColor: ['#D1D5DB', '#BFDBFE', '#BBF7D0', '#FECACA'],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'bottom',
          },
        },
      }
    });
  </script>
</body>
</html>
