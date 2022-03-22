<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Main extends BaseController
{
    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Admin',
        ];
        return view('main/layout', $data);
    }
}