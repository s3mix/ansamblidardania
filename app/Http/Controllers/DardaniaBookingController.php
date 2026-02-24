<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DardaniaBookingController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:80'],
            'phone' => ['required','string','max:40'],
            'event_type' => ['required','string','max:50'],
            'event_date' => ['required','date'],
            'start_time' => ['nullable','string','max:20'],
            'package' => ['required','string','max:60'],
            'city_select' => ['required','string','max:80'], // could be a city name OR "__other__"
            'city_other' => ['nullable','string','max:80'],
            'venue' => ['nullable','string','max:120'],
            'notes' => ['nullable','string','max:500'],
        ]);

        $city = $data['city_select'] === '__other__'
            ? trim((string)($data['city_other'] ?? ''))
            : $data['city_select'];

        if ($data['city_select'] === '__other__' && $city === '') {
            return back()->withErrors(['city_other' => 'Please type your city.'])->withInput();
        }

        $date = Carbon::parse($data['event_date'])->format('d M Y');

        $businessName = config('dardania.business_name');
        $waNumber = preg_replace('/\D+/', '', config('dardania.whatsapp_e164'));

        $lines = array_filter([
            "Booking request — {$businessName}",
            "",
            "Name: {$data['name']}",
            "WhatsApp/Phone: {$data['phone']}",
            "Event: {$data['event_type']}",
            "Date: {$date}",
            $data['start_time'] ? "Start time: {$data['start_time']}" : null,
            "City: {$city}",
            $data['venue'] ? "Venue: {$data['venue']}" : null,
            "Package: {$data['package']}",
            $data['notes'] ? "Notes: {$data['notes']}" : null,
            "",
            "Please confirm availability + price + deposit (if any).",
        ]);

        $msg = implode("\n", $lines);
        $url = "https://wa.me/{$waNumber}?text=" . urlencode($msg);

        return redirect()->away($url);
    }
}
