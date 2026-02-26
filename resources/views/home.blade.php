@extends('layouts.app')

@section('content')
@php
  // ✅ Put your YouTube video IDs here (NOT full links)
  $videoIds = [
    'Sqs51PSfSZA',
    'kNTp_lxVP74',
    'TqXy4ex86m8',
    'eJ0SWQS625A',
    '8QpQG4Kmnuc',
    'Vj_S6ih6TQw',
  ];

  // ✅ Put your photo filenames here (must exist in public/media/)
  $photoFiles = [
    '01.jpeg','02.jpeg','03.jpeg','04.jpeg','05.jpeg','06.jpeg','07.jpeg','08.jpeg',
    '09.jpeg','10.jpg','11.jpeg','12.jpeg','13.jpeg','14.jpeg','15.jpeg','16.jpeg'
  ];
@endphp

<section class="hero" id="top">
  <div class="container hero__grid">
    <div class="hero__content">
      <div class="badge">🎶 Weddings • Engagements • Events • Albania & Kosovo</div>
      <h1>Traditional Albanian Dance that elevates your celebration.</h1>
      <p class="lead">
        {{ config('dardania.business_name') }} performs with authentic costumes, powerful choreography, and clean coordination.
        Book fast — we confirm availability on WhatsApp.
      </p>

      <div class="hero__cta">
        <a class="btn btn--primary" href="#book">Check availability</a>
        <a class="btn btn--ghost" href="#performances">Watch performances</a>
      </div>

      <div class="trust">
        <div class="trust__item">
          <div class="trust__num">Professional</div>
          <div class="trust__label">Coordinated timing</div>
        </div>
        <div class="trust__item">
          <div class="trust__num">Authentic</div>
          <div class="trust__label">Traditional costumes</div>
        </div>
        <div class="trust__item">
          <div class="trust__num">Fast</div>
          <div class="trust__label">WhatsApp confirmation</div>
        </div>
      </div>
    </div>

    <div class="hero__card">
      <h2>Quick Reservation</h2>
      <p class="muted small">Send details — we respond with availability + price.</p>
      @include('booking-form', ['cities' => $cities, 'big' => false])
    </div>
  </div>
</section>

<section class="section section--alt" id="performances">
  <div class="container">
    <div class="section__head">
      <h2>Performances</h2>
      <p class="muted">Video + photos gallery (opens in modals).</p>
    </div>

    <div class="mediaGrid">
      {{-- Featured video --}}
      <div class="mediaCard">
        <div class="mediaHead">
          <h3>Video</h3>
          <button class="btn btn--small btn--ghost" type="button" data-open="videoGallery">Gallery</button>
        </div>

        <div class="videoWrap">
          <iframe
            src="https://www.youtube.com/embed/{{ $videoIds[0] ?? '' }}"
            title="Ansambli Dardania Performance"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen></iframe>
        </div>
      </div>

      {{-- Photo thumbnails --}}
      <div class="mediaCard">
        <div class="mediaHead">
          <h3>Photos</h3>
          <button class="btn btn--small btn--ghost" type="button" data-open="photoGallery">Gallery</button>
        </div>

        <div class="thumbGrid">
          @foreach(array_slice($photoFiles, 0, 6) as $img)
            <button class="thumb" type="button" data-lightbox="{{ asset('media/'.$img) }}">
              <img src="{{ asset('media/'.$img) }}" alt="Ansambli Dardania performance photo">
            </button>
          @endforeach
        </div>
      </div>
    </div>

    {{-- FULLSCREEN LIGHTBOX --}}
    <div class="modal" id="lightbox" aria-hidden="true">
      <div class="modal__backdrop" data-close></div>
      <div class="modal__panel modal__panel--wide">
        <button class="modal__close" type="button" data-close aria-label="Close">✕</button>
        <img id="lightboxImg" src="" alt="Full photo" />
      </div>
    </div>

    {{-- PHOTO GALLERY MODAL --}}
    <div class="modal" id="photoGallery" aria-hidden="true">
      <div class="modal__backdrop" data-close></div>
      <div class="modal__panel modal__panel--wide">
        <div class="modal__head">
          <h3>Photo Gallery</h3>
          <button class="modal__close" type="button" data-close aria-label="Close">✕</button>
        </div>

        <div class="gridGallery">
          @foreach($photoFiles as $img)
            <button class="thumb thumb--big" type="button" data-lightbox="{{ asset('media/'.$img) }}">
              <img src="{{ asset('media/'.$img) }}" alt="Ansambli Dardania performance photo">
            </button>
          @endforeach
        </div>
      </div>
    </div>

    {{-- VIDEO GALLERY MODAL --}}
    <div class="modal" id="videoGallery" aria-hidden="true">
      <div class="modal__backdrop" data-close></div>
      <div class="modal__panel modal__panel--wide">
        <div class="modal__head">
          <h3>Video Gallery</h3>
          <button class="modal__close" type="button" data-close aria-label="Close">✕</button>
        </div>

        <div class="videoGrid">
          @foreach($videoIds as $id)
            <div class="videoWrap">
              <iframe
                src="https://www.youtube.com/embed/{{ $id }}"
                title="Ansambli Dardania Video"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen></iframe>
            </div>
          @endforeach
        </div>
      </div>
    </div>

  </div>
</section>

<section class="section" id="packages">
  <div class="container">
    <div class="section__head">
      <h2>Packages</h2>
      <p class="muted">Choose a package — final price depends on location, schedule, and ensemble size.</p>
    </div>

    <div class="pricing">
      @foreach($packages as $p)
        <article class="pricecard {{ !empty($p['featured']) ? 'pricecard--best' : '' }}">
          @if(!empty($p['featured']))
            <div class="ribbon">Most booked</div>
          @endif
          <h3>{{ $p['name'] }}</h3>
          <p class="muted">{{ $p['desc'] ?? '' }}</p>
          <ul>
            @foreach($p['bullets'] as $b)
              <li>{{ $b }}</li>
            @endforeach
          </ul>
          <div style="margin-top:14px">
            <a class="btn btn--small btn--primary" href="#book" data-pick-package="{{ $p['name'] }}">Select</a>
          </div>
        </article>
      @endforeach
    </div>
  </div>
</section>

<section class="section section--alt" id="faq">
  <div class="container">
    <div class="section__head">
      <h2>FAQ</h2>
      <p class="muted">Clear answers. Less back-and-forth. More bookings.</p>
    </div>

    <div class="faq">
      <details>
        <summary>Do you travel to all cities in Albania and Kosovo?</summary>
        <p>Yes. Travel cost may apply depending on distance and schedule.</p>
      </details>
      <details>
        <summary>How long is a typical performance?</summary>
        <p>Most weddings choose 20-30 minutes. We can customize longer programs.</p>
      </details>
      <details>
        <summary>Do you need sound equipment?</summary>
        <p>Usually the venue provides sound. If not, tell us and we’ll advise options.</p>
      </details>
      <details>
        <summary>How do we reserve the date?</summary>
        <p>We confirm availability and send details. A deposit may be required to reserve.</p>
      </details>
    </div>
  </div>
</section>

<section class="section" id="book">
  <div class="container">
    <div class="section__head">
      <h2>Book {{ config('dardania.business_name') }}</h2>
      <p class="muted">Fill this out — it opens WhatsApp with your full request ready to send.</p>
    </div>

    <div class="bookGrid">
      <div class="bookInfo">
        <ul class="bullets">
          <li>✅ Fast confirmation</li>
          <li>✅ Albania + Kosovo</li>
          <li>✅ Professional coordination</li>
        </ul>
      </div>

      <div class="bookForm">
        @include('booking-form', ['cities' => $cities, 'big' => true])
      </div>
    </div>
  </div>
</section>
@endsection