<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\PageController; // Add this at the top with other use statements
use Illuminate\Http\Request;

class MaintenanceMode
{
    public function handle(Request $request, Closure $next)
    {
        // Your existing middleware logic here
        
        return $next($request);
    }
}