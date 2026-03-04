@extends('layouts.customer')

@section('title', 'Account Settings')
@section('page-title', 'Account Settings')

@section('content')
<div style="max-width: 600px;">
    <div class="card-solid" style="margin-bottom: 2rem;">
        <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--primary); margin-bottom: 2rem;">Change Password</h2>
        
        <form action="{{ route('customer.settings.update') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase; margin-bottom: 0.5rem;">New Password</label>
                <input type="password" name="password" required
                       style="width: 100%; padding: 0.875rem; border: 1px solid var(--border-light); border-radius: 0.75rem; background: white; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border-light)'">
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase; margin-bottom: 0.5rem;">Confirm New Password</label>
                <input type="password" name="password_confirmation" required
                       style="width: 100%; padding: 0.875rem; border: 1px solid var(--border-light); border-radius: 0.75rem; background: white; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border-light)'">
            </div>

            <button type="submit" class="btn-solid btn-primary-solid" style="width: 100%; justify-content: center; padding: 1rem;">
                Update Password ⚙️
            </button>
        </form>
    </div>

    <div class="card-solid" style="background: rgba(239, 68, 68, 0.05); border: 1px solid rgba(239, 68, 68, 0.1);">
        <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--danger); margin-bottom: 1rem;">Danger Zone</h2>
        <p style="color: var(--text-muted-light); font-size: 0.875rem; margin-bottom: 1.5rem;">Once you delete your account, there is no going back. Please be certain.</p>
        
        <button disabled style="background: var(--danger); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 700; opacity: 0.5; cursor: not-allowed;">
            Delete Account (Contact Support)
        </button>
    </div>
</div>
@endsection
