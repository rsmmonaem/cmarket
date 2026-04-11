<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $q = $request->get('q');
        
        $users = User::where(function($query) use ($q) {
                $query->where('name', 'LIKE', "%{$q}%")
                      ->orWhere('phone', 'LIKE', "%{$q}%")
                      ->orWhere('referral_code', 'LIKE', "%{$q}%");
            })
            ->where('id', '!=', auth()->id())
            ->limit(10)
            ->get(['id', 'name', 'phone', 'referral_code']);

        return response()->json($users->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'referral_code' => $user->referral_code,
                'display' => "{$user->name} - {$user->referral_code} ({$user->phone})"
            ];
        }));
    }
}
