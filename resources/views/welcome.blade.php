<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('dardania.business_name', 'Ansambli Dardania') }}</title>
  <meta name="description" content="Traditional Albanian dance performances for weddings and events in Albania & Kosovo. Book Ansambli Dardania." />

  <meta name="wa-number" content="{{ preg_replace('/\D+/', '', config('dardania.whatsapp_e164')) }}">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<header class="header">
  <div class="container header__inner">
    <div class="header__bar">
      <a class="brand" href="{{ route('home') }}" aria-label="{{ config('dardania.business_name', 'Ansambli Dardania') }}">
        <span class="logo__mark" aria-hidden="true">AD</span>
        <span class="brand__name brand__name--desktop">{{ config('dardania.business_name', 'Ansambli Dardania') }}</span>
      </a>

      <div class="header__title" aria-hidden="true">{{ config('dardania.business_name', 'Ansambli Dardania') }}</div>

      <button
        class="nav__toggle"
        id="navToggle"
        type="button"
        aria-label="Open menu"
        aria-expanded="false"
        aria-controls="navMenu"
      >
        <span></span><span></span><span></span>
      </button>

      <nav class="nav" id="navMenu" aria-label="Primary">
        <a class="nav__link" href="#performances">Performances</a>
        <a class="nav__link" href="#packages">Packages</a>
        <a class="nav__link" href="#faq">FAQ</a>
        <a class="nav__link nav__cta" href="#book">Book</a>
      </nav>
    </div>
  </div>
</header>

<main>
  @yield('content')
</main>

<footer class="footer">
  <div class="container footer__grid">
    <div>
      <div class="logo logo--footer">
        <span class="logo__mark">AD</span>
        <span class="logo__text">{{ config('dardania.business_name', 'Ansambli Dardania') }}</span>
      </div>
      <p class="muted small">Traditional Albanian dance for weddings and events.</p>
    </div>

    <div class="footer__cols">
      <div>
        <h4>Sections</h4>
        <a href="#performances">Performances</a>
        <a href="#packages">Packages</a>
        <a href="#book">Book</a>
      </div>
      <div>
        <h4>Contact</h4>
        <a id="waLink" href="#">WhatsApp</a>
        <a href="mailto:hello@example.com">hello@example.com</a>
      </div>
    </div>
  </div>

  <div class="container footer__bottom">
    <span class="muted small">© <span id="year"></span> {{ config('dardania.business_name', 'Ansambli Dardania') }}.</span>
    <a class="muted small" href="#top">Back to top ↑</a>
  </div>
</footer>

<a class="fab" id="fabWhatsApp" href="#" aria-label="Chat on WhatsApp">
  <span>WhatsApp</span>
</a>
</body>
</html>
