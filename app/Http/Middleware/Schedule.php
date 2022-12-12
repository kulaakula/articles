<?php

namespace App\Http\Middleware;

use App\Models\Schedul;
use Closure;
use Illuminate\Http\Request;

class Schedule
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $schedule = new Schedul();
        $schedule->path = $request->path();
        $schedule->user_name = auth()->user()->name;
        $schedule->save();
        // Log::alert($request->path());
        return $next($request);
    }
}
