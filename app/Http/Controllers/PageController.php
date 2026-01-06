<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(Request $request, $slug = null)
    {
        // Handle dynamic pages or return 404
        if ($slug && view()->exists($slug)) {
            return view($slug);
        }
        abort(404);
    }
}
