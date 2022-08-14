<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AutogenController extends Controller
{
    
    public function index()
    {
        $tableName = 'users';
        $data = Schema::getColumnListing($tableName);

        echo '<br>';
        echo '====================================== RESOURCE ============================';
        echo '<br>';
        foreach ($data as $key) {
            echo '\'' . $key . '\' => $this->' . $key . ',<br>';
        }
        echo '<br>';
        echo '====================================== INI UNTUK request->only ============================';
        echo '<br>';
        foreach ($data as $key) {
            echo '\'' . $key . '\',';
        }
        echo '<br>';
        echo '====================================== INI UNTUK QUASAR ============================';
        echo '<br>';
        foreach ($data as $key) {
            echo $key . ': "", <br>';
        }
        echo '<br>';
        // return new JsonResponse($data);
    }
}
