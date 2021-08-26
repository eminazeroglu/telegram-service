<?php

namespace Azeroglu\Telegram\Facades;

use Illuminate\Support\Facades\Facade;

class Telegram extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'telegram';
    }
}
