@php
  $big = $big ?? false;
@endphp

<form class="form {{ $big ? 'form--big' : '' }}" method="POST" action="{{ route('booking.store') }}">
  @csrf

  <div class="form__row grid2">
    <label>
      Name
      <input name="name" value="{{ old('name') }}" required>
    </label>
    <label>
      WhatsApp / Phone
      <input name="phone" value="{{ old('phone') }}" placeholder="+355 ..." required>
    </label>
  </div>
  <div class="form__row grid2">
    <label>
      Event type
      <select name="event_type" required>
        <option value="" disabled @selected(old('event_type')===null)>Select</option>
        <option @selected(old('event_type')==='Wedding')>Wedding</option>
        <option @selected(old('event_type')==='Engagement')>Engagement</option>
        <option @selected(old('event_type')==='Corporate')>Corporate</option>
        <option @selected(old('event_type')==='Other')>Other</option>
      </select>
    </label>

    <label>
      Package
      <select name="package" id="packageSelect" required>
        <option value="" disabled @selected(old('package')===null)>Select</option>
        <option @selected(old('package')==='Wedding Essentials')>Wedding Essentials</option>
        <option @selected(old('package')==='Full Celebration')>Full Celebration</option>
        <option @selected(old('package')==='Custom / Festival')>Custom / Festival</option>
      </select>
    </label>
  </div>

  <div class="form__row grid2">
    <label>
      Event date
      <input type="date" name="event_date" value="{{ old('event_date') }}" required>
    </label>
    <label>
      Start time (optional)
      <input name="start_time" value="{{ old('start_time') }}" placeholder="e.g. 19:30">
    </label>
  </div>

  <div class="form__row grid2">
    <label>
      City
      <select name="city_select" id="citySelect" required>
        <option value="" disabled @selected(old('city_select')===null)>Select a city</option>

        <optgroup label="Albania">
          @foreach(($cities['albania'] ?? []) as $c)
            <option value="{{ $c }}" @selected(old('city_select')===$c)>{{ $c }}</option>
          @endforeach
        </optgroup>

        <optgroup label="Kosovo">
          @foreach(($cities['kosovo'] ?? []) as $c)
            <option value="{{ $c }}" @selected(old('city_select')===$c)>{{ $c }}</option>
          @endforeach
        </optgroup>

        <option value="__other__" @selected(old('city_select')==='__other__')>Other (type manually)</option>
      </select>
    </label>

    <label id="cityOtherWrap" style="display:none;">
      Other city
      <input name="city_other" id="cityOther" value="{{ old('city_other') }}" placeholder="Type your city">
    </label>
  </div>

  <div class="form__row">
    <label>
      Venue / Address (optional)
      <input name="venue" value="{{ old('venue') }}" placeholder="Venue name or address">
    </label>
  </div>

  <div class="form__row">
    <label>
      Notes (optional)
      <textarea name="notes" rows="3" placeholder="Schedule, special dances, number of guests, etc.">{{ old('notes') }}</textarea>
    </label>
  </div>
<button class="waBtn btn btn--primary btn--full" type="button">
  Send request on WhatsApp
</button>

  @if($errors->any())
    <p class="fineprint">Fix the form errors and try again.</p>
  @endif
</form>
