<?php

namespace App\Http\Controllers;

use App\Models\Lietotajs;
use Illuminate\Support\Facades\Mail;

class LietotajuApstiprinasanasController extends Controller
{
    public function apstiprinat($id)
    {
        $user = Lietotajs::findOrFail($id);

        $user->aktivs = 1;
        $user->save();

        Mail::raw(
            "Sveiki, {$user->vards}! Jūsu profils ir apstiprināts. Tagad varat pieslēgties sistēmai.",
            function ($message) use ($user) {
                $message->to($user->epasts)
                    ->subject('Profils apstiprināts');
            }
        );

        return back()->with('success', 'Lietotājs apstiprināts un e-pasts nosūtīts.');
    }
}