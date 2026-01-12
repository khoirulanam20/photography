<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use App\Observers\BookingObserver;
use App\Models\Booking;
use App\Models\Profil;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Booking::observe(BookingObserver::class);

        // Share profil perusahaan untuk kebutuhan logo/nama di seluruh view (termasuk halaman auth).
        // Dibuat aman: kalau DB belum siap/ada error, tetap biarkan view jalan tanpa data profil.
        try {
            $profil = Profil::query()->first();
        } catch (\Throwable $e) {
            $profil = null;
        }

        view()->share('profil', $profil);
    }
}
