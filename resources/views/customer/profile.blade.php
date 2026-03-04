@extends('layouts.customer')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<div style="max-width: 600px;">
    <div class="card-solid">
        <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--primary); margin-bottom: 2rem;">Personal Information</h2>
        
        <form action="{{ route('customer.profile.update') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase; margin-bottom: 0.5rem;">Full Name</label>
                <input type="text" name="name" value="{{ auth()->user()->name }}" required
                       style="width: 100%; padding: 0.875rem; border: 1px solid var(--border-light); border-radius: 0.75rem; background: white; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border-light)'">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase; margin-bottom: 0.5rem;">Email Address</label>
                <input type="email" name="email" value="{{ auth()->user()->email }}" required
                       style="width: 100%; padding: 0.875rem; border: 1px solid var(--border-light); border-radius: 0.75rem; background: white; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border-light)'">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase; margin-bottom: 0.5rem;">Phone Number</label>
                <input type="text" name="phone" value="{{ auth()->user()->phone }}" required
                       style="width: 100%; padding: 0.875rem; border: 1px solid var(--border-light); border-radius: 0.75rem; background: white; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border-light)'">
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted-light); text-transform: uppercase; margin-bottom: 0.5rem;">Default Address</label>
                <textarea name="address" rows="3" placeholder="Enter your shipping address"
                          style="width: 100%; padding: 0.875rem; border: 1px solid var(--border-light); border-radius: 0.75rem; background: white; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border-light)'">{{ auth()->user()->address }}</textarea>
            </div>

            <button type="submit" class="btn-solid btn-primary-solid" style="width: 100%; justify-content: center; padding: 1rem;">
                Update Profile ✨
            </button>
        </form>
    </div>
</div>
@endsection
