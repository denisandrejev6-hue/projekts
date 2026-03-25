<?php

namespace App\Http\Controllers;

use App\Models\Lietotajs;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LietotajuApstiprinasanasController extends Controller
{
    public function apstiprinat($id)
    {
        $user = Lietotajs::findOrFail($id);

        $user->aktivs = 1;
        $user->save();

        try {
            Mail::raw(
                "Sveiki, {$user->vards}! Jūsu profils ir apstiprināts. Tagad varat pieslēgties sistēmai.",
                function ($message) use ($user) {
                    $message->to($user->epasts)
                        ->subject('Profils apstiprināts');
                }
            );

            return back()->with('success', 'Lietotājs apstiprināts un e-pasts nosūtīts.');
        } catch (\Throwable $e) {
            Log::error('Neizdevās nosūtīt apstiprinājuma e-pastu: ' . $e->getMessage());

            return back()->with('success', 'Lietotājs apstiprināts, bet e-pastu nosūtīt neizdevās.');
        }
    }
}