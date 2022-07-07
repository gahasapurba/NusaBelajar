<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('NusaBelajar - Verifikasi Email')
                ->line('Klik tombol dibawah ini untuk memverifikasi email anda.')
                ->action('Verifikasi Email', $url)
                ->line('Harap lakukan verifikasi email dalam tempo 15 menit, setelah itu, email ini akan expired / tidak berlaku lagi. Jika anda merasa sedang tidak melakukan pendaftaran, maka abaikan email ini.');
        });

        ResetPassword::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('NusaBelajar - Reset Password')
                ->line('Anda menerima email ini karena kami mendeteksi adanya permintaan perubahan password atau reset password, dari akun anda.')
                ->action('Reset Password', $url)
                ->line('Email ini akan expired / tidak berlaku lagi dalam :count menit.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')])
                ->line('Jika anda merasa sedang tidak melakukan permintaan reset password, maka abaikan email ini.');
        });
    }
}