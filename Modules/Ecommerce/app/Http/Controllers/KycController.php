<?php

namespace Modules\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Kyc;
use App\Services\ImageUploadService;
use App\Services\AuditService;
use Illuminate\Http\Request;

class KycController extends Controller
{
    protected $imageService;
    protected $auditService;

    public function __construct(ImageUploadService $imageService, AuditService $auditService)
    {
        $this->imageService = $imageService;
        $this->auditService = $auditService;
    }

    public function index()
    {
        $user = auth()->user();
        $kyc = $user->kyc;
        return view('ecommerce::kyc.index', compact('kyc'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->kyc && $user->kyc->status === 'approved') {
            return back()->with('error', 'Your KYC is already approved.');
        }

        $request->validate([
            'document_type' => 'required|in:nid,passport,driving_license',
            'document_number' => 'required|string|max:50',
            'document_front' => 'required',
            'document_back' => 'required',
        ]);

        $frontPath = $this->imageService->upload($request->file('document_front'), 'kyc/front');
        $backPath = $this->imageService->upload($request->file('document_back'), 'kyc/back');

        $kyc = Kyc::updateOrCreate(
            ['user_id' => $user->id],
            [
                'document_type' => $request->document_type,
                'document_number' => $request->document_number,
                'document_front' => $frontPath,
                'document_back' => $backPath,
                'status' => 'pending',
                'rejection_reason' => null,
            ]
        );

        $this->auditService->log('kyc_submitted', $kyc, null, $kyc->toArray());

        return back()->with('success', 'KYC documents submitted successfully. Please wait for admin approval.');
    }
}
