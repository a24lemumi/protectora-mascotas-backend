<?php

namespace App\Controllers;

class SetupController extends BaseController
{
    public function index()
    {
        require_once __DIR__ . '/../../public/setup.php';
    }
}
