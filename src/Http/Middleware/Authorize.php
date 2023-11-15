<?php

namespace Itsmejoshua\Novaspatiepermissions\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Nova\Nova;
use Itsmejoshua\Novaspatiepermissions\Novaspatiepermissions;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  Request  $request
     * @param  \Closure(Request):mixed  $next
     * @return Response
     */
    public function handle($request, $next)
    {
        $tool = collect(Nova::registeredTools())->first([$this, 'matchesTool']);

        if (optional($tool)->authorize($request)) {
            return $next($request);
        }

        abort(403);
    }

    /**
     * Determine whether this tool belongs to the package.
     *
     * @param  \Laravel\Nova\Tool  $tool
     * @return bool
     */
    public function matchesTool($tool): bool
    {
        return $tool instanceof Novaspatiepermissions;
    }
}
