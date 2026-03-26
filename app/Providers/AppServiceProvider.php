<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Reģistrē lietotnes servisus.
     */
    public function register(): void
    {
        //
    }

    /**
     * Inicializē lietotnes konfigurāciju un pielāgotās validācijas.
     */
    public function boot(): void
    {
        // Lietotne un datumu formatēšana izmanto vienu un to pašu lokalizāciju.
        app()->setLocale(config('app.locale'));

        if (class_exists(\Carbon\Carbon::class)) {
            \Carbon\Carbon::setLocale(config('app.locale'));
        }

        // Pārbauda, vai beigu laiks nav agrāks par sākuma laiku.
        \Illuminate\Support\Facades\Validator::extend('time_after_or_equal', function ($attribute, $value, $parameters, $validator) {
            $other = $validator->getData()[$parameters[0]] ?? null;
            
            if (! $other || ! $value) {
                return true;
            }

            // Laiki tiek salīdzināti H:i formātā.
            return strtotime($value) >= strtotime($other);
        });

        // Pārbauda, vai sākuma laiks nav vēlāk par beigu laiku.
        \Illuminate\Support\Facades\Validator::extend('time_before_or_equal', function ($attribute, $value, $parameters, $validator) {
            $other = $validator->getData()[$parameters[0]] ?? null;
            
            if (! $other || ! $value) {
                return true;
            }

            // Laiki tiek salīdzināti H:i formātā.
            return strtotime($value) <= strtotime($other);
        });
    }
}
