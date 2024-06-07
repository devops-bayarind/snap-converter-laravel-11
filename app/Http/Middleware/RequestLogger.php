<?php

namespace App\Http\Middleware;

use App\Helpers\CommonHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        CommonHelper::Log("REQUEST URL: ".$request->url());
        CommonHelper::Log("REQUEST HEADER: ".json_encode($request->header()));
        CommonHelper::Log("REQUEST BODY: ".$request->getContent());
        $response = $next($request);
        CommonHelper::Log("RESPONSE BODY: ".$response->getContent());
        return $response;
    }
}
