<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DardaniaBookingController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:120'],
            'phone'       => ['required','string','max:60'],
            'event_type'  => ['required','string','max:60'],
            'package'     => ['required','string','max:120'],
            'event_date'  => ['required','date'],
            'start_time'  => ['nullable','string','max:20'],
            'city_select' => ['required','string','max:120'],
            'city_other'  => ['nullable','string','max:120'],
            'venue'       => ['nullable','string','max:200'],
            'notes'       => ['nullable','string','max:1000'],
        ]);

        $city = $data['city_select'] === '__other__'
            ? trim((string)($data['city_other'] ?? ''))
            : $data['city_select'];

        if ($data['city_select'] === '__other__' && $city === '') {
            return back()->withErrors(['city_other' => 'Please type your city.'])->withInput();
        }

        // Put your WhatsApp number in config/dardania.php OR .env
        // Example: +3556xxxxxxx  => store as 3556xxxxxxx (no +, no spaces)
        $waNumber = config('dardania.whatsapp_number') ?: env('WHATSAPP_NUMBER');

        if (!$waNumber) {
            return back()->withErrors(['phone' => 'WhatsApp number is not configured on the server.'])->withInput();
        }

        $lines = [
            "Hi! I want to book " . config('dardania.business_name', 'Ansambli Dardania') . ".",
            "",
            "Name: {$data['name']}",
            "WhatsApp/Phone: {$data['phone']}",
            "Event type: {$data['event_type']}",
            "Package: {$data['package']}",
            "Date: {$data['event_date']}",
        ];

        if (!empty($data['start_time'])) $lines[] = "Start time: {$data['start_time']}";
        $lines[] = "City: {$city}";
        if (!empty($data['venue'])) $lines[] = "Venue/Address: {$data['venue']}";
        if (!empty($data['notes'])) $lines[] = "Notes: {$data['notes']}";

        $text = implode("\n", $lines);

        $url = "https://wa.me/" . preg_replace('/\D+/', '', $waNumber) . "?text=" . urlencode($text);

        return redirect()->away($url);
    }
}