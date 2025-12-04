{{-- ============================================
     ACCOUNT DETAILS — PREMIUM VERSION
     File: resources/views/account/account_details.blade.php
============================================= --}}

<div class="premium-card">

    <h3 class="premium-title mb-4">
        <i class="fa-solid fa-user-gear me-2"></i> Account Details
    </h3>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success premium-alert">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROR DISPLAY --}}
    @if($errors->any())
        <div class="alert alert-danger premium-alert">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data" class="premium-form">
        @csrf

        <div class="row g-4">

            {{-- PROFILE IMAGE --}}
            <div class="col-lg-4 text-center">
                
                <div class="profile-image-wrapper mb-3">
                    <img src="{{ $customer->profile_image ? asset('storage/'.$customer->profile_image) : asset('assets/images/profile-placeholder.png') }}"
                         alt="Profile"
                         class="profile-preview">

                    <label class="upload-btn mt-2">
                        Change Photo
                        <input type="file" name="profile_image" accept="image/*" hidden>
                    </label>
                </div>

            </div>

            <div class="col-lg-8">

                {{-- FULL NAME --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $customer->name) }}"
                           class="form-control premium-input" required>
                </div>

                {{-- EMAIL --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                           class="form-control premium-input" required>
                </div>

                {{-- PHONE --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}"
                           class="form-control premium-input">
                </div>

            </div>

        </div>

        <hr class="my-4">

        {{-- ADDRESS SECTION ,This below address section is not used
        <h5 class="fw-bold mb-3">Address Information</h5>

        <div class="row g-4">

            <div class="col-md-6">
                <label class="form-label fw-bold">Country</label>
                <input type="text" name="country" value="{{ old('country', $customer->country) }}"
                       class="form-control premium-input">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">State</label>
                <input type="text" name="state" value="{{ old('state', $customer->state) }}"
                       class="form-control premium-input">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">City</label>
                <input type="text" name="city" value="{{ old('city', $customer->city) }}"
                       class="form-control premium-input">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Zip Code</label>
                <input type="text" name="zip_code" value="{{ old('zip_code', $customer->zip_code) }}"
                       class="form-control premium-input">
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Street Address</label>
                <textarea name="address_line" rows="2" class="form-control premium-input">{{ old('address_line', $customer->address_line) }}</textarea>
            </div>

        </div>

        <hr class="my-4">--}}

        {{-- PASSWORD SECTION ,This below is commented later will update this
        <h5 class="fw-bold mb-3">Change Password</h5>

        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-bold">New Password</label>
                <input type="password" name="password" class="form-control premium-input">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control premium-input">
            </div>
        </div>--}}

        <button class="premium-btn-primary mt-4 w-100">
            Save Changes
        </button>

    </form>

</div>


{{-- ============================================
    PREMIUM STYLING (MATCHES YOUR DESIGN SYSTEM)
============================================ --}}
@push('styles')
<style>

.premium-form .form-control {
    border-radius: 12px;
    padding: 12px 14px;
    border: 1px solid #e3e3e3;
    transition: .25s;
}
.premium-form .form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.2rem rgba(255,157,0,0.25);
}

.profile-image-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
}
.profile-preview {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid #fff;
    box-shadow: var(--shadow);
}

.upload-btn {
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    color: var(--primary);
    padding: 6px 12px;
    border-radius: 10px;
    background: #fff7e6;
    border: 1px solid var(--primary);
    transition: .25s;
}
.upload-btn:hover {
    background: var(--primary);
    color: #fff;
}

.premium-alert {
    border-radius: 10px;
    font-size: 14px;
}

</style>
@endpush
