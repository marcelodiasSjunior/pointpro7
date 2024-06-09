<?php

if (!function_exists('runCommandWooRequests')) {
    function runCommandWooRequests()
    {
        exec('php /var/www/api/artisan app:process-woo-request');
    }
}
