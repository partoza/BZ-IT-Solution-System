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

  <!-- Favicon / Touch Icon -->
  <link rel="icon" type="image/png" href="{{ asset('assets/img/logo/bz-logo-green.png') }}" />
  <link rel="apple-touch-icon" href="{{ asset('assets/img/logo/bz-logo-green.png') }}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Axios -->
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

  <!-- Toastr -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  {{-- Extra head content (optional) --}}
  @stack('head')
</head>

<body class="@yield('body-class', 'font-poppins bg-[#F5F5F5] text-gray-800')">
  {{-- Primary content yield for all pages --}}
  @yield('content')

  {{-- Optional page scripts --}}
  @stack('scripts')
</body>
</html>
