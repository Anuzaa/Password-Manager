<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;

class HomeController extends Controller
{
    public function mail()
    {
        $name = 'Anuja';
        Mail::to('anuja.bhattarai@introcept.co')->send(new SendMailable($name));

        return 'Email was sent';
    }
}
