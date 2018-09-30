<?php

namespace App\Http\Middleware;

use App\Message;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class CheckMessages
{
    public static $newMessages = false;

    public static $numberMessages = 0;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $receivedMessages = DB::table('messages')->where('receiver_id', '=', Auth::id())->where('viewed', '=', false)
            ->count();
        self::$newMessages = ($receivedMessages > 0);
        self::$numberMessages = $receivedMessages;
        return $next($request);
    }
}
