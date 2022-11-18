<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Mail\PesanEmail;
use App\Models\Surveyor;
use App\Models\User;
use App\Notifications\EmailNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class KirimEmailController extends Controller
{

    // public static function index($data)
    // {
    //     $nama = $data['name'];
    //     $email = $data['email'];
    //     $password = $data['password'];

    //     $data_email = [
    //         'title' => 'Info penting !!!',
    //         'url' => 'http://localhost:9000/login',
    //         'nama' => $nama,
    //         'email' => $email,
    //         'password' => $password

    //     ];
    //     Mail::to($data['email'])->send(new PesanEmail($data_email));
    //     return new JsonResponse(['message' => 'Email terkirim'], 200);
    // }

    public static function notifEmail($data)
    {
        // return $data['email'];

        $url = 'http://localhost:9000/login';
        // $user = User::where('id', $data->id)->get();
        $user = User::find($data['id']);
        $data_email = [
            'subjek' => 'LIPA MITRA',
            'title' => 'SISTEM INFORMASI LIPA MITRA',
            'body' => 'Informasi Penting ',
            // 'email' => $user[0]->email,
            'email' => $data['email'],
            'password' => $data['password'],
            'namaBtn' => 'Login',
            'url' => $url,
            'thanks' => 'Terimakasih',
            'salutation' => 'MOHON TIDAK MEMBAGIKAN INFORMASI INI KEPADA SIAPAPUN',
            'id' => $user

        ];
        // return response()->json($user[0]->email);
        Notification::sendNow($user, new EmailNotification($data_email));

        // $user = User::query()->find(1);
        // $user->notify(new EmailNotification($user, $url));

        return response()->json(['message' => 'Email terkirim', 'data' => $user], 200);
    }
}
