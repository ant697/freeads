<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Middleware\CheckMessages;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('newMessages');
        
    }

    protected function checkReferer($redirect = null, $flash_message = null)
    {
        if (!isset($_SERVER['HTTP_REFERER'])) {
            if ($redirect !== null) {
                if ($flash_message !== null) {
                    return redirect($redirect)->with('flash_message', $flash_message);
                } else {
                    return redirect($redirect);
                }
            } else {
                if ($flash_message !== null) {
                    return redirect('posts')->with('flash_message', $flash_message);
                } else {
                    return redirect('posts');
                }
            }
        }
    }


    protected function getRefererPerm()
    {
        return (!isset($_SERVER['HTTP_REFERER']));
    }

    protected function checkRight($id)
    {
        return (Auth::id() === intval($id) || Auth::user()->role === 'admin');
    }

}
