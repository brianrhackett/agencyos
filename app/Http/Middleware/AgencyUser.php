<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AgencyUser
{
	public function handle(Request $request, Closure $next): Response
	{
		if (!auth()->user()?->isAgencyUser()) {
			abort(403);
		}

		return $next($request);
	}
}