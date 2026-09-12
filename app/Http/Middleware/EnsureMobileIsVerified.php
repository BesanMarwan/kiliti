<?php
namespace App\Http\Middleware;
use App\Actions\ApiActions;
use App\Constants\ResponseCode;
use App\Http\Resources\User\UserResource;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class EnsureMobileIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user() ||$request->user()->status == 'not_verified') {
            $user=UserResource::make($request->user());
            return ApiActions::generateResponse(compact('user'),'verify_mobile',ResponseCode::NOT_VERTIFIED);
        }
        if (! $request->user() ||$request->user()->status == 'disabled') {
            $user=UserResource::make($request->user());
            return ApiActions::generateResponse(compact('user'),'user_blocked',ResponseCode::NOT_VERTIFIED);
        }

        return $next($request);
    }
}
