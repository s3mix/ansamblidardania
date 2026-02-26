<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DardaniaBookingController;

Route::get('/', function () {

    // ✅ Albania municipalities (all)
    $cities = [
        'albania' => [
            'Berat','Kuçovë','Poliçan',
            'Bulqizë','Dibër','Klos','Mat',
            'Durrës','Krujë','Shijak',
            'Elbasan','Belsh','Cërrik','Gramsh','Librazhd','Peqin','Prrenjas',
            'Fier','Divjakë','Lushnjë','Mallakastër','Patos','Roskovec',
            'Gjirokastër','Dropull','Këlcyrë','Libohovë','Memaliaj','Përmet','Tepelenë',
            'Has','Kukës','Tropojë',
            'Kamëz','Kavajë','Rrogozhinë','Tiranë','Vorë',
            'Lezhë','Kurbin','Mirditë',
            'Malësi e Madhe','Shkodër','Vau i Dejës','Pukë','Fushë-Arrëz',
            'Korçë','Devoll','Kolonjë','Maliq','Pogradec','Pustec',
            'Skrapar',
            'Delvinë','Finiq','Konispol','Sarandë',
            'Selenicë','Himarë','Vlorë',
        ],

        // ✅ Kosovo municipalities (all)
        'kosovo' => [
            'Deçan','Dragash','Ferizaj','Fushë Kosovë','Gjakovë','Gjilan',
            'Gllogoc','Graçanicë','Hani i Elezit','Istog','Junik','Kaçanik',
            'Kamenicë','Klinë','Kllokot','Leposaviq','Lipjan','Malishevë',
            'Mamushë','Mitrovicë','Novobërdë','Obiliq','Partesh','Pejë',
            'Podujevë','Prishtinë','Prizren','Rahovec','Ranillugu','Skenderaj',
            'Shtërpcë','Shtime','Suharekë','Viti','Vushtrri','Zubin Potok',
            'Zvečan',
        ],
    ];

    // Keep your existing packages logic (if you already have $packages elsewhere, replace this)
    $packages = config('dardania.packages', []);

    return view('home', compact('cities', 'packages'));
});

Route::post('/booking', [DardaniaBookingController::class, 'store'])
    ->name('booking.store');

    use App\Http\Controllers\DardaniaPageController;

Route::get('/', [DardaniaPageController::class, 'home'])->name('home');
