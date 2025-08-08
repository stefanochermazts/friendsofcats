<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cat;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    /**
     * Get platform statistics for homepage
     */
    public function platformStats(): JsonResponse
    {
        try {
            // Total cats registered
            $totalCats = Cat::count();
            
            // Successful adoptions (cats with stato = 'adottato')
            $successfulAdoptions = Cat::where('stato', 'adottato')->count();
            
            // Community members (all registered users)
            $communityMembers = User::where('email_verified_at', '!=', null)->count();
            
            // Languages (fixed at 6)
            $supportedLanguages = 6;
            
            return response()->json([
                'total_cats' => $totalCats,
                'successful_adoptions' => $successfulAdoptions,
                'community_members' => $communityMembers,
                'supported_languages' => $supportedLanguages,
                'cats_helped' => $totalCats, // Alias for hero section
                'registered_cats' => $totalCats, // Alias for stats section
            ]);
            
        } catch (\Exception $e) {
            // Fallback values in case of error
            return response()->json([
                'total_cats' => 0,
                'successful_adoptions' => 0,
                'community_members' => 0,
                'supported_languages' => 6,
                'cats_helped' => 0,
                'registered_cats' => 0,
            ]);
        }
    }
}
