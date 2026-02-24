<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ config('dardania.business_name', 'Ansambli Dardania') }}</title>

  {{-- Favicons --}}
  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-512.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-512.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon-512.png') }}">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
  <header class="header">

  {{-- DESKTOP NAV (your existing one) --}}
  <div class="container header__inner">
    <a class="brand" href="{{ url('/') }}">
      <img src="{{ asset('media/logo.png') }}" alt="Ansambli Dardania" class="brand__logo">
      <span class="brand__name">{{ config('dardania.business_name', 'Ansambli Dardania') }}</span>
    </a>

    <nav class="nav" aria-label="Main navigation">
      <div class="socials">
        <a href="https://www.instagram.com/ansambli_dardania_tropoj" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
          <svg viewBox="0 0 24 24"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm5 5a5 5 0 1 0 0 10a5 5 0 0 0 0-10zm6.5-.5a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3z"/></svg>
        </a>
        <a href="https://www.tiktok.com/@dardania_tropoje" target="_blank" rel="noopener noreferrer" aria-label="TikTok">
          <svg viewBox="0 0 24 24"><path d="M16 1c1 2 3 3 5 3v4c-2 0-4-1-5-2v7a6 6 0 1 1-6-6h1v4h-1a2 2 0 1 0 2 2V1h4z"/></svg>
        </a>
        <a href="https://www.youtube.com/@shpresartmemia147" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
          <svg viewBox="0 0 24 24"><path d="M23 7s-1-4-4-4H5C2 3 1 7 1 7s-1 4-1 5 1 5 1 5 1 4 4 4h14c3 0 4-4 4-4s1-4 1-5-1-5-1-5zM10 15V9l5 3-5 3z"/></svg>
        </a>
      </div>

      <a class="nav__link" href="#performances">Performances</a>
      <a class="nav__link" href="#packages">Packages</a>
      <a class="nav__link nav__cta" href="#book">Reserve</a>
    </nav>
  </div>


  {{-- MOBILE NAV ONLY --}}
  {{-- MOBILE NAV ONLY --}}
<div class="mnav">
  <a href="{{ url('/') }}" class="mnav__left" aria-label="Home">
    <img src="{{ asset('media/logo.png') }}" alt="Ansambli Dardania" class="mnav__logo">
  </a>

  <div class="mnav__title">Ansambli Dardania</div>

  <button id="mnavBtn"
          class="mnav__btn"
          type="button"
          aria-label="Open menu"
          aria-expanded="false"
          aria-controls="mnavMenu">
    <span></span>
    <span></span>
    <span></span>
  </button>

  <div id="mnavMenu" class="mnav__menu" aria-hidden="true">

    {{-- Social Media Icons --}}
    <div class="mnav__socials">
      <a href="https://www.instagram.com/ansambli_dardania_tropoj"
         target="_blank" rel="noopener noreferrer" aria-label="Instagram">
        <svg viewBox="0 0 24 24">
          <path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm5 5a5 5 0 1 0 0 10a5 5 0 0 0 0-10zm6.5-.5a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3z"/>
        </svg>
      </a>

      <a href="https://www.tiktok.com/@dardania_tropoje"
         target="_blank" rel="noopener noreferrer" aria-label="TikTok">
        <svg viewBox="0 0 24 24">
          <path d="M16 1c1 2 3 3 5 3v4c-2 0-4-1-5-2v7a6 6 0 1 1-6-6h1v4h-1a2 2 0 1 0 2 2V1h4z"/>
        </svg>
      </a>

      <a href="https://www.youtube.com/@shpresartmemia147"
         target="_blank" rel="noopener noreferrer" aria-label="YouTube">
        <svg viewBox="0 0 24 24">
          <path d="M23 7s-1-4-4-4H5C2 3 1 7 1 7s-1 4-1 5 1 5 1 5 1 4 4 4h14c3 0 4-4 4-4s1-4 1-5-1-5-1-5zM10 15V9l5 3-5 3z"/>
        </svg>
      </a>
    </div>

    <a class="mnav__link" href="#performances">Performances</a>
    <a class="mnav__link" href="#packages">Packages</a>
    <a class="mnav__link mnav__cta" href="#book">Reserve</a>

  </div>
</div>


</header>



  <main>
    @yield('content')
  </main>

  <footer class="footer">
    <div class="container">
      <p class="muted small">
        © {{ date('Y') }} {{ config('dardania.business_name', 'Ansambli Dardania') }}. Traditional Albanian dance for weddings & events.
      </p>
    </div>
  </footer>
</body>
</html>
