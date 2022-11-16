<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Mail\PesanEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class KirimEmailController extends Controller
{
    public static function index($data)
    {
        $nama = $data['name'];
        $email = $data['email'];
        $password = $data['password'];

        $data_email = [
            'title' => 'Info penting !!!',
            'url' => 'http://localhost:9000/login',
            'nama' => $nama,
            'email' => $email,
            'password' => $password

        ];
        Mail::to($data['email'])->send(new PesanEmail($data_email));
        return new JsonResponse(['message' => 'Email terkirim'], 200);
    }
}
