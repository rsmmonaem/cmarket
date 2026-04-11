<?php

namespace Modules\Customer\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\RankService;
use Illuminate\Http\Request;

class GenerationController extends Controller
{
    protected $rankService;
    protected $pointService;

    public function __construct(RankService $rankService, \App\Services\PointService $pointService)
    {
        $this->rankService = $rankService;
        $this->pointService = $pointService;
    }

    public function index()
    {
        $user = auth()->user();
        $generations = $this->rankService->getGenerations($user);
        
        return view('customer::generations.index', compact('generations'));
    }

    public function upgradeWithVoucher(Request $request)
    {
        $request->validate([
            'required_points' => 'required|integer|min:1'
        ]);

        try {
            $this->pointService->upgradeWithVoucher(auth()->user(), $request->required_points);
            return redirect()->back()->with('success', 'Congratulations! You have successfully upgraded your position. 🚀');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
