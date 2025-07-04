<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Filament\Pages\Dashboard;
use Symfony\Component\HttpFoundation\Response;

class RedirectToProperPanelMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->is_admin) {
            return redirect()->to(Dashboard::getUrl(panel: 'admin'));
        }
        return $next($request);
    }
}
