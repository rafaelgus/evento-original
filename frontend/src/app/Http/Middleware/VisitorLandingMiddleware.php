<?php
namespace App\Http\Middleware;

use Closure;
use EventoOriginal\Core\Services\VisitorLandingService;

class VisitorLandingMiddleware
{
    private $visitorLandingService;

    public function __construct(VisitorLandingService $visitorLandingService)
    {
        $this->visitorLandingService = $visitorLandingService;
    }

    public function handle($request, Closure $next)
    {
        $this->visitorLandingService->sync();

        return $next($request);
    }
}
