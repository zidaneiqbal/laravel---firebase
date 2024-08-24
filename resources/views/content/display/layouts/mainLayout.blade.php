@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset

<!DOCTYPE html>
{{-- {!! Helper::applClasses() !!} --}}
@php
$configData = Helper::applClasses();
@endphp

<html lang="@if(session()->has('locale')){{session()->get('locale')}}@else{{$configData['defaultLanguage']}}@endif" data-textdirection="{{ env('MIX_CONTENT_DIRECTION') === 'rtl' ? 'rtl' : 'ltr' }}" class="{{ ($configData['theme'] === 'light') ? '' : $configData['layoutTheme'] }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title')</title>
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/logo/favicon.ico')}}">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Load DataTables CSS and JS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- Include core + vendor Styles --}}
  @include('panels/styles')
  <style>
    /* Custom style for the navbar toggler */
    .navbar {
      background-color: #55423d;
    }

    .navbar-toggler {
      background-color: #ffc0ad;
      /* Background color for toggler */
    }

    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='%23271c19' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
      /* Change color of icon to #271c19 */
    }

    .nav-link {
      font-size: 20px;
      font-weight: 700;
      color: #fffffe;

      .active {
        color: #271c19;
      }
    }

    .nav-link:hover {
      color: #271c19;
    }

    .active {
      background-color: #ffc0ad;
      border-radius: 8px;
      color: #271c19 !important;
    }
  </style>
  @stack('styles')
</head>

<!-- Navbar -->
<nav class="navbar navbar-expand-sm">
  <div class="container">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mt-1" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item {{ request()->routeIs('about.display') ? 'active' : 'inactive' }}">
          <a class="nav-link {{ request()->routeIs('about.display') ? 'active' : 'inactive' }}"" href=" {{ route('about.display') }}">About</a>
        </li>
        <li class="nav-item {{ request()->routeIs('certificates.display') ? 'active' : 'inactive' }}">
          <a class="nav-link {{ request()->routeIs('certificates.display') ? 'active' : '' }}"" href=" {{ route('certificates.display') }}">Certificates</a>
        </li>
        <li class="nav-item {{ request()->routeIs('portfolio.display') ? 'active' : 'inactive' }}">
          <a class="nav-link {{ request()->routeIs('portfolio.display') ? 'active' : '' }}"" href=" {{ route('portfolio.display') }}">Portfolio</a>
        </li>
        <li class="nav-item {{ request()->routeIs('chatbot.display') ? 'active' : 'inactive' }}">
          <a class="nav-link {{ request()->routeIs('chatbot.display') ? 'active' : '' }}"" href=" {{ route('chatbot.display') }}">Chat Bot</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<body>
  @yield('content')
  @stack('scripts')
</body>

</html>