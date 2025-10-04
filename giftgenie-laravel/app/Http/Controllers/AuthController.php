<?php

namespace App\Http\Controllers;

// Plain PHP controller for the scaffold
class AuthController
{
    public function index()
    {
        ob_start();
        include __DIR__ . '/../../resources/views/auth.blade.php';
        return ob_get_clean();
    }
}
