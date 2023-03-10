<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BasicController extends Controller
{
    public function index()
    {
        return view('homepage', [
            "judul" => "Halaman Home",
        ]);
    }

    public function about()
    {
        return view('about', [
            "judul" => "Halaman About",
            "name" => "Ihsan Miftahul Huda",
            "job" => "Web Developer",
            "alamat" => "Jl. Raya Cibubur No. 1",
            "image" => "assets/images/banner.svg",
        ]);
    }
}
