<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\UserMessage;
use Illuminate\Database\Eloquent\Collection;

class SharedViewData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check())
        {
            $messageCount = UserMessage::where('user_id', '=', Auth::user()['id'])
                ->where('is_read', '=', 'false')
                ->get()->count();

            $onlineFriends = Auth::user()->friends()
                ->where('is_online', '=', 1)
                ->get();

            $activities = new Collection();
            foreach (Auth::user()->friends()->get() as $friend)
            {
                $coll = $friend->activities()->get();
                $activities = $activities->merge($friend->activities()->get());
            }
            $activities = $activities->sortByDesc('created_at')->take(5);

            View::share('message_count', $messageCount);
            View::share('online_friends', $onlineFriends);
            View::share('activities', $activities);
        }

        return $next($request);
    }
}
