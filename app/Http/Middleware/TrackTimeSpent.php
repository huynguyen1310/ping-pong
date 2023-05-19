<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TrackTimeSpent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // Get the current time
        $currentTime = time();

        // Get the last accessed time from the session
        $lastAccessedTime = $request->session()->get('last_accessed_time');

        // Calculate the time spent on the page
        $timeSpent = $lastAccessedTime ? $currentTime - $lastAccessedTime : 0;

        // Store the current time in the session
        $request->session()->put('last_accessed_time', $currentTime);

        // Pass the request to the next middleware in the pipeline
        $response = $next($request);

        // Calculate the time spent on the page again in case the response modified the session
        $timeSpent = $lastAccessedTime ? $currentTime - $lastAccessedTime : 0;

        // Store the time spent in the session
        $request->session()->put('time_spent', $timeSpent);

        // Return the response
        return $response;
    }
}
