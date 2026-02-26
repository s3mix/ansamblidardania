@extends('layouts.app')

@section('content')
<section class="section" id="book">
  <div class="container">
    <div class="section__head">
      <h2>Reserve {{ config('dardania.business_name') }}</h2>
      <p class="muted">Fill this out — it opens WhatsApp with your full request ready to send.</p>
    </div>

    <div class="bookGrid">
      <div class="bookInfo">
        <ul class="bullets">
          <li>✅ Fast confirmation</li>
          <li>✅ Albania + Kosovo</li>
          <li>✅ Professional coordination</li>
        </ul>

        <p class="fineprint">
          Tip: If you came here by mistake, go back to <a href="{{ route('home') }}" style="text-decoration:underline">Home</a>.
        </p>
      </div>

      <div class="bookForm">
        @include('booking-form', ['cities' => $cities, 'big' => true])
      </div>
    </div>
  </div>
</section>
@endsection
