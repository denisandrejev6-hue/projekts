<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
    * Apstrādā pieprasījumu un pārbauda, vai lietotājs drīkst piekļūt maršrutam.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        if (! auth()->check()) {
            return redirect('/login');
        }

        // Lomu pārbaude šobrīd ir atslēgta, bet kods ir atstāts atjaunošanai.
        // $allowed = array_map('trim', explode(',', $roles));
        // if (! in_array(auth()->user()->loma, $allowed, true)) {
        //     abort(403, 'Piekļuve liegta');
        // }

        return $next($request);
    }
}