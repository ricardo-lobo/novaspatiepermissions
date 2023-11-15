<?php

namespace Itsmejoshua\Novaspatiepermissions;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;
use Spatie\Permission\PermissionRegistrar;

class ForgetCachedPermissions
{
	/**
	 * Handle the incoming request.
	 *
	 * @param NovaRequest|Request $request
	 * @param Closure                 $next
	 *
	 * @return Response
	 */
	public function handle($request, $next)
	{
		$response = $next($request);

		if ($request->is('nova-api/*/detach') || $request->is('nova-api/*/*/attach/*')) {
			$permissionKey = (Nova::resourceForModel(app(PermissionRegistrar::class)->getPermissionClass()))::uriKey();

			if ($request->viaRelationship === $permissionKey) {
				app(PermissionRegistrar::class)->forgetCachedPermissions();
			}
		}

		return $response;
	}
}
