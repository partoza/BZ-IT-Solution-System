<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Login - BZ IT Solutions')</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Custom Tailwind Config -->
  <script src="{{ asset('js/tailwind-config.js') }}"></script>
</head>

<body class="font-poppins bg-gray-100">
  @yield('content')
</body>
</html>
