<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'BZ IT Solutions')</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Vite Assets -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-poppins bg-gray-50 text-gray-800">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-primary text-white p-6">
      <h1 class="text-xl font-semibold mb-8">BZ IT Solutions</h1>
      <nav class="space-y-3">
        <a href="#" class="block py-2 px-3 rounded-lg bg-white/10">Dashboard</a>
        <a href="#" class="block py-2 px-3 rounded-lg hover:bg-white/10">Inventory</a>
        <a href="#" class="block py-2 px-3 rounded-lg hover:bg-white/10">Customer</a>
      </nav>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-8">
      @yield('content')
    </main>
  </div>
</body>
</html>
