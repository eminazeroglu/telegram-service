<?php

namespace Azeroglu\Telegram;

use Illuminate\Support\ServiceProvider;

class TelegramServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton('telegram', function ($app) {
            dd($app);
        });
    }

    public function provides(): array
    {
        return ['telegram' => Telegram::class];
    }
}
