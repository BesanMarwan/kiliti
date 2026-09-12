<?php

use App\Actions\ApiActions;
use App\Constants\ResponseCode;
use App\Http\Middleware\EnsureMobileIsVerified;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__.'/../routes/web.php',
//            __DIR__.'/../routes/admin.php'
        ],
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
//        then: function () {
//
//                Route::prefix('api')
//                    ->middleware('api')
//                    ->namespace('App\\Http\\Controllers')
//                    ->group(base_path('routes/api.php'));
//
//                Route::prefix('api/v1/user')
//                    ->middleware(['api'])
//                    ->namespace('App\\Http\\Controllers')
//                    ->group(base_path('routes/v1/user.php'));
//
//                Route::prefix('api/v1/app')
//                    ->middleware('api')
//                    ->namespace('App\\Http\\Controllers')
//                    ->group(base_path('routes/v1/app.php'));
//
//            Route::middleware('web')
//                ->prefix(LaravelLocalization::setLocale().'/'.config('custom.admin_prefix'))->middleware('web')
//                ->prefix(config('custom.admin_prefix'))->middleware('web')
//                ->group(base_path('routes/admin.php'));
//
//        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [
//            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \App\Http\Middleware\TrustProxies::class,
            \App\Http\Middleware\Jsonify::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class
        ]);

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
            'auth' => \App\Http\Middleware\Authenticate::class,
            'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
            'can' => \Illuminate\Auth\Middleware\Authorize::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
            'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'verified_mobile' => EnsureMobileIsVerified::class,
            'jsonify'    => \App\Http\Middleware\Jsonify::class,

            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,



            'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
            'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
            'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
            'localeViewPath'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,

        ]);


    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // 1. معالجة خطأ "الصفحة غير موجودة" (404 NotFound)
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return ApiActions::generateResponse(null, 'no_data', ResponseCode::NOT_FOUND);
            }
        });

        // 2. معالجة خطأ "المستخدم غير مسجل الدخول" (401 Unauthorized)
        $exceptions->render(function (AuthenticationException $exception, Request $request) {
            // إذا كان الطلب يتوقع JSON أو يخص الـ API، أرجع استجابة JSON المخصصة
            if ($request->expectsJson() || $request->routeIs('*/api/*')) {
                return ApiActions::generateResponse(null, 'not_authenticated', ResponseCode::UNAUTHORIZED);
            }

            // إذا كان طلب متصفح عادي (Web)، قم بتوجيهه لصفحة تسجيل الدخول المناسبة
            $guards = $exception->guards();
            $guard = reset($guards); // جلب الحارس (Guard) الأول المستخدم

            if ($guard === 'admin') {
                return redirect()->guest(route('admin.login'));
            }

            return redirect()->guest($exception->redirectTo() ?? route('login'));
        });
        // 3. معالجة أخطاء التحقق من البيانات (422 Validation Error)
        $exceptions->render(function (ValidationException $exception, Request $request) {
            if ($request->expectsJson() || $request->routeIs('*/api/*')) {
                $err = [];
                // تحويل الأخطاء المرجعة إلى الشكل المخصص الذي حددته في كودك القديم
                foreach ($exception->errors() as $key => $value) {
                    $col = collect($value);
                    $n = new \stdClass();
                    $n->field = $key;
                    $n->error = $col->first();
                    $err[] = $n;
                }

                return ApiActions::generateResponse(['errors' => $err], 'validation_error', ResponseCode::VALIDATION_ERROR);
            }
        });

    })->create();
