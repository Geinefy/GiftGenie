<?php

namespace App\Http\Controllers;

// Plain PHP controller for the scaffold
class GiftsController
{
    public function index()
    {
        ob_start();
        include __DIR__ . '/../../resources/views/gifts.blade.php';
        return ob_get_clean();
    }
}
