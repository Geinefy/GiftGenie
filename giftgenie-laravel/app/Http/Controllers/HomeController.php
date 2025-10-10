<?php

namespace App\Http\Controllers;

// Plain PHP controller used by the lightweight scaffold (does not require Laravel framework).
class HomeController
{
    public function index()
    {
        // Return view content as a string by including the Blade-like file.
        ob_start();
        include __DIR__ . '/../../resources/views/home.blade.php';
        return ob_get_clean();
    }

    public function dashboard()
    {
        ob_start();
        include __DIR__ . '/../../resources/views/dashboard.blade.php';
        return ob_get_clean();
    }
}
