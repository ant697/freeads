<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Message;
use App\Post;
use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class IndexController {
    public function showIndex()
    {
        echo '<h1>hello World</h1>';
    }
}