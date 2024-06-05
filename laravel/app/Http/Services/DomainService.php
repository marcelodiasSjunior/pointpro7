<?php

namespace App\Http\Services;

class DomainService
{
    public static function getFullHost($subdomain = 'loading')
    {
        $port = '';
        if (config('app.http_port')) {
            $port = ':' . config('app.http_port');
        }

        $url = 'https://' . $subdomain . '.' . config('app.domain') . $port;

        return $url;
    }
}
