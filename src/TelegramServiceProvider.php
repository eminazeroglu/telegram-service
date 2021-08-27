<?php

namespace Azeroglu\Telegram;

use Illuminate\Support\ServiceProvider;

class TelegramServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('telegram', function ($app) {
            return new Telegram();
        });

        $this->app->alias('telegram', Telegram::class);
    }

    public function provides(): array
    {
        return ['telegram' => Telegram::class];
    }
}
