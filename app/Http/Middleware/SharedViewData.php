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
            $currentTime = date("Y-m-d H:i:s");
            $expireTime = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime($currentTime)));
            Auth::user()->update(['online_till' => $expireTime]);

            $messageCount = UserMessage::where('user_id', '=', Auth::user()['id'])
                ->where('is_read', '=', 'false')
                ->get()->count();

            $currentTime = strtotime(date("Y-m-d H:i:s"));

            $onlineFriends = Auth::user()->friends()
                ->where('online_till', '>', date("Y-m-d H:i:s"))
                ->get()
                ->merge(Auth::user()->friendsReverse()
                    ->where('online_till', '>', date("Y-m-d H:i:s"))
                    ->get());

            $friends = Auth::user()->friends()->get()
                ->merge(Auth::user()->friendsReverse()->get());

            $activities = new Collection();
            foreach ($friends as $friend)
            {
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
