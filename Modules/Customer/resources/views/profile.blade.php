@extends('layouts.customer')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<div style="max-width: 600px;">
    <div class="card-solid">
        <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--primary); margin-bottom: 2rem;">Personal Information</h2>
        
        <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Avatar Section -->
            <div style="display: flex; flex-direction: column; align-items: center; margin-bottom: 2.5rem; position: relative;">
                <div style="width: 120px; height: 120px; border-radius: 3rem; overflow: hidden; background: var(--bg-light); border: 4px solid white; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); margin-bottom: 1rem;">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 3rem; color: var(--text-muted-light);">👤</div>
                    @endif
                </div>
                <label for="avatar-input" style="background: var(--primary); color: white; padding: 0.5rem 1rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 800; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    Change Photo 📸
                </label>
                <input type="file" id="avatar-input" name="avatar" style="display: none;" onchange="this.form.submit()">
            </div>

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
                Save Changes ✨
            </button>
        </form>
    </div>
</div>
@endsection
