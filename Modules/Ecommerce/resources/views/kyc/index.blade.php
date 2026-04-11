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

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--text-light); margin-bottom: 0.5rem;">Document Front View</label>
                    <div style="padding: 1.5rem; border: 2px dashed var(--border-light); border-radius: 1rem; text-align: center; background: var(--bg-light); cursor: pointer; height: 160px; display: flex; flex-direction: column; align-items: center; justify-content: center; overflow: hidden; position: relative;" onclick="document.getElementById('doc_front').click()">
                        <div id="preview_front_wrap" style="display: flex; flex-direction: column; align-items: center;">
                            <div style="font-size: 2rem; margin-bottom: 0.5rem;">🖼️</div>
                            <p style="font-size: 0.75rem; color: var(--text-muted-light);">Front Part (JPG/PNG)</p>
                        </div>
                        <img id="preview_front" style="display: none; position: absolute; inset: 0; width: 100%; h-full; object-fit: cover;">
                        <input type="file" id="doc_front" name="document_front" style="display: none;" required onchange="handlePreview(this, 'preview_front', 'preview_front_wrap')">
                    </div>
                    @error('document_front')<p style="color: var(--danger); font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 700; color: var(--text-light); margin-bottom: 0.5rem;">Document Back View</label>
                    <div style="padding: 1.5rem; border: 2px dashed var(--border-light); border-radius: 1rem; text-align: center; background: var(--bg-light); cursor: pointer; height: 160px; display: flex; flex-direction: column; align-items: center; justify-content: center; overflow: hidden; position: relative;" onclick="document.getElementById('doc_back').click()">
                        <div id="preview_back_wrap" style="display: flex; flex-direction: column; align-items: center;">
                            <div style="font-size: 2rem; margin-bottom: 0.5rem;">🖼️</div>
                            <p style="font-size: 0.75rem; color: var(--text-muted-light);">Back Part (JPG/PNG)</p>
                        </div>
                        <img id="preview_back" style="display: none; position: absolute; inset: 0; width: 100%; h-full; object-fit: cover;">
                        <input type="file" id="doc_back" name="document_back" style="display: none;" required onchange="handlePreview(this, 'preview_back', 'preview_back_wrap')">
                    </div>
                    @error('document_back')<p style="color: var(--danger); font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>@enderror
                </div>
            </div>

            <button type="submit" class="btn-solid" style="width: 100%; justify-content: center; padding: 1rem; border-radius: 1rem; font-weight: 800; font-size: 1rem; transition: transform 0.2s; background: var(--primary); color: #fff; border: none; cursor: pointer;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                Submit for Verification 🚀
            </button>
        </form>
    @endif
</div>

<script>
function handlePreview(input, previewId, wrapId) {
    const file = input.files[0];
    const preview = document.getElementById(previewId);
    const wrap = document.getElementById(wrapId);
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            wrap.style.display = 'none';
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
