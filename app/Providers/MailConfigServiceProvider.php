<?php

namespace App\Providers;

use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if (Schema::hasTable('options')){
            $generalOption = DB::table('options')->where('option_group','general')->get();
            $generalOption = $generalOption->pluck('option_value','option_name')->toArray();
            Config::set('generalOption', $generalOption);

            $mailOption = DB::table('options')->where('option_group','mail')->get();
            $mailOption = $mailOption->pluck('option_value','option_name')->toArray();
            $mail = Config::get('mail');
            $mail['mailers']['smtp']['host']        = $mailOption['mail_host'];
            $mail['mailers']['smtp']['port']        = $mailOption['mail_port'];
            $mail['mailers']['smtp']['encryption']  = $mailOption['mail_encryption'] ?? 'tls';
            $mail['mailers']['smtp']['username']    = $mailOption['mail_username'];
            $mail['mailers']['smtp']['password']    = $mailOption['mail_password'];
            Config::set('mail', $mail);
        }

    }
}
