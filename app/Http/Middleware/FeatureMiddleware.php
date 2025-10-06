<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\FeatureAccessService;
use Symfony\Component\HttpFoundation\Response;

class FeatureMiddleware
{
    public function __construct(protected FeatureAccessService $featureService) {}

    public function handle(Request $request, Closure $next, string $featureKey)
    {
        $user = $request->user();

        if (!$user || !$this->featureService->userHasFeature($user, $featureKey)) {
            return response()->json([
                'message' => 'Feature not available for your current plan.'
            ], 403);
        }

        return $next($request);
    }
}
