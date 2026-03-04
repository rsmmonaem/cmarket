@extends('layouts.customer')

@section('title', 'KYC Verification')
@section('page-title', 'Verify Your Identity')

@section('content')
<div class="card-solid" style="max-width: 800px; margin: 0 auto;">
    @php $user = auth()->user(); @endphp

    @if($user->kyc)
        <div style="margin-bottom: 2rem; padding: 1.5rem; border-radius: 1rem; text-align: center;
            {{ $user->kyc->status === 'approved' ? 'background: rgba(16, 185, 129, 0.1); border: 1px solid var(--success); color: var(--success);' : '' }}
            {{ $user->kyc->status === 'pending' ? 'background: rgba(59, 130, 246, 0.1); border: 1px solid var(--info); color: var(--info);' : '' }}
            {{ $user->kyc->status === 'rejected' ? 'background: rgba(239, 68, 68, 0.1); border: 1px solid var(--danger); color: var(--danger);' : '' }}">
            
            <div style="font-size: 3rem; margin-bottom: 1rem;">
                @if($user->kyc->status === 'approved') ✅
                @elseif($user->kyc->status === 'pending') ⏳
                @elseif($user->kyc->status === 'rejected') ❌
                @endif
            </div>
            <h2 style="font-weight: 800; margin-bottom: 0.5rem;">KYC Status: {{ strtoupper($user->kyc->status) }}</h2>
            <p style="opacity: 0.8;">
                @if($user->kyc->status === 'approved')
                    Your identity has been verified. You now have full access to all features!
                @elseif($user->kyc->status === 'pending')
                    Your documents are being reviewed by our team. This usually takes 24-48 hours.
                @elseif($user->kyc->status === 'rejected')
                    Reason: {{ $user->kyc->rejection_reason ?? 'Please re-submit your documents with clearer images.' }}
                @endif
            </p>
        </div>
    @endif

    @if(!$user->kyc || $user->kyc->status === 'rejected')
        <h3 style="margin-bottom: 1.5rem; font-weight: 700;">Submit Verification Documents</h3>
        <p style="color: var(--text-muted-light); margin-bottom: 2rem;">Please provide a clear photo of your government-issued ID to unlock all platform features.</p>
        
        <form action="{{ route('kyc.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--text-light); margin-bottom: 0.5rem;">Document Type</label>
                <select name="document_type" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--border-light); background: var(--bg-light);" required>
                    <option value="nid">National ID Card (NID)</option>
                    <option value="passport">Passport</option>
                    <option value="driving_license">Driving License</option>
                </select>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--text-light); margin-bottom: 0.5rem;">Document Number</label>
                <input type="text" name="document_number" placeholder="Enter ID number" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--border-light); background: var(--bg-light);" required>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--text-light); margin-bottom: 0.5rem;">Upload Document Image</label>
                <div style="padding: 2rem; border: 2px dashed var(--border-light); border-radius: 1rem; text-align: center; background: var(--bg-light); cursor: pointer;" onclick="document.getElementById('doc_file').click()">
                    <div style="font-size: 2.5rem; margin-bottom: 1rem;">📸</div>
                    <p style="font-size: 0.875rem; color: var(--text-muted-light);">Click to select or drag and drop your image file here</p>
                    <p style="font-size: 0.75rem; color: var(--text-muted-light); margin-top: 0.5rem;">JPG, PNG or PDF (Max 2MB)</p>
                    <input type="file" id="doc_file" name="document_file" style="display: none;" required onchange="updateFileName(this)">
                    <div id="file_name" style="margin-top: 1rem; font-weight: 700; color: var(--primary);"></div>
                </div>
            </div>

            <button type="submit" class="btn-solid btn-primary-solid" style="width: 100%; justify-content: center; padding: 1rem;">
                Submit for Verification 🚀
            </button>
        </form>
    @endif
</div>

<script>
function updateFileName(input) {
    const fileName = input.files[0] ? input.files[0].name : '';
    document.getElementById('file_name').textContent = fileName ? 'Selected: ' + fileName : '';
}
</script>
@endsection
