<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Todolist</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 p-6">

  <h1 class="text-3xl font-bold mb-6">Dashboard Todolist</h1>

  <!-- Filter Waktu -->
  <div class="mb-4 flex items-center justify-between">
    <label class="font-medium">Filter Waktu:</label>
    <select id="filterWaktu" class="p-2 border rounded">
      <option value="today">Hari Ini</option>
      <option value="tomorrow">Besok</option>
      <option value="1week">1 Minggu</option>
      <option value="1month">1 Bulan</option>
    </select>
  </div>

  <!-- Ringkasan -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-gray-200 p-4 rounded shadow">
      <h2 class="text-sm text-gray-600">Belum Dikerjakan</h2>
      <p class="text-xl font-bold text-gray-700">5</p>
    </div>
    <div class="bg-blue-200 p-4 rounded shadow">
      <h2 class="text-sm text-blue-600">Sedang Dikerjakan</h2>
      <p class="text-xl font-bold text-blue-700">3</p>
    </div>
    <div class="bg-green-200 p-4 rounded shadow">
      <h2 class="text-sm text-green-600">Selesai</h2>
      <p class="text-xl font-bold text-green-700">8</p>
    </div>
    <div class="bg-red-200 p-4 rounded shadow">
      <h2 class="text-sm text-red-600">Lewat Deadline</h2>
      <p class="text-xl font-bold text-red-700">2</p>
    </div>
  </div>

  <!-- Chart -->
  <div class="bg-white p-4 rounded shadow mb-6">
    <h2 class="text-xl font-semibold mb-2">Statistik Tugas</h2>
    <canvas id="taskChart"></canvas>
  </div>

  <!-- Tabel Tugas -->
  <div class="bg-white p-4 rounded shadow">
    <h2 class="text-xl font-semibold mb-2">Daftar Tugas</h2>
    <table class="w-full table-auto text-left">
      <thead>
        <tr class="bg-gray-200">
          <th class="p-2">Nama Tugas</th>
          <th class="p-2">Rincian</th>
          <th class="p-2">Deadline</th>
          <th class="p-2">Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="p-2">Membuat desain UI</td>
          <td class="p-2">Desain tampilan dashboard</td>
          <td class="p-2">2025-05-15</td>
          <td class="p-2 text-blue-600">Sedang Dikerjakan</td>
        </tr>
        <tr>
          <td class="p-2">Meeting dengan tim</td>
          <td class="p-2">Bahas progress tugas</td>
          <td class="p-2">2025-05-12</td>
          <td class="p-2 text-green-600">Selesai</td>
        </tr>
        <tr>
          <td class="p-2">Update backend API</td>
          <td class="p-2">Tambahkan filter status</td>
          <td class="p-2">2025-05-10</td>
          <td class="p-2 text-red-600">Lewat Deadline</td>
        </tr>
      </tbody>
    </table>
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
          backgroundColor: [
            '#E5E7EB', // gray
            '#BFDBFE', // blue
            '#BBF7D0', // green
            '#FECACA'  // red
          ],
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
