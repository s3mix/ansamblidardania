<?php

namespace App\Http\Controllers;

class DardaniaPageController extends Controller
{
    public function home()
    {
        $cities = config('cities');
        $packages = [
            [
                'name' => 'Tupana Show',
                'time' => '5-10 min',
                'bullets' => ['Custom choreography','Perfect for entrances'],
                'tag' => 'Simple & elegant',
            ],
            [
                'name' => 'Full Celebration',
                'time' => '25-30 minutes',
                'bullets' => ['6-7 dance sets', '8 Dancers','2 Tupana','1 Muzika', 'Couple participation moment'],
                'tag' => 'Most booked',
                'featured' => true,
            ],
            [
                'name' => 'Custom / Festival',
                'time' => '45–60+ min',
                'bullets' => ['Custom choreography', 'Bigger ensemble options', 'For festivals & diaspora events'],
                'tag' => 'Custom program',
            ],
        ];

        return view('home', compact('cities', 'packages'));
    }
}