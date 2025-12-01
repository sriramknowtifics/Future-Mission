@php
$customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'Register Basic - Pages')

@section('vendor-style')
@vite(['resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('page-style')
@vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('vendor-script')
@vite(['resources/assets/vendor/libs/@form-validation/popular.js',
'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

@section('page-script')
@vite(['resources/assets/js/pages-auth.js'])
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-6">
      <!-- Register Card -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center mb-6">
            <a href="{{ url('/') }}" class="app-brand-link">
              <span class="app-brand-logo demo">@include('_partials.macros')</span>
              <span class="app-brand-text demo text-heading fw-bold">{{ config('variables.templateName') }}</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-1">Adventure starts here 🚀</h4>
          <p class="mb-6">Make your app management easy and fun!</p>

         <form action="{{ route('register.post') }}" method="POST">
      @csrf
            <div class="mb-6 form-control-validation">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control"  name="name" value="{{ old('name') }}" placeholder="Enter your username"
                autofocus />
            </div>
            <div class="mb-6 form-control-validation">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" name="email" type="email" value="{{ old('email') }}" placeholder="Enter your email" />
            </div>
            <div class="mb-6 form-password-toggle form-control-validation">
              <label class="form-label" for="password">Password</label>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password"
                  placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                  aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="icon-base ti tabler-eye-off"></i></span>
              </div>
            </div>
            <div class="mb-6 form-password-toggle form-control-validation">
              <label class="form-label" for="password">Confirm password</label>
              <div class="input-group input-group-merge">
                <input type="password"  name="password_confirmation" class="form-control" name="password"
                  placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                  aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="icon-base ti tabler-eye-off"></i></span>
              </div>
            </div>

 

            <div class="my-8 form-control-validation">
              <div class="form-check mb-0 ms-2">
                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" />
                <label class="form-check-label" for="terms-conditions">
                  I agree to
                  <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#termsModal">
                      privacy policy & terms
                  </a>

                </label>
              </div>
            </div>
            <button class="btn btn-primary d-grid w-100">Register</button>
          </form>


          <div class="divider my-6">
            <div class="divider-text">or</div>
          </div>

          <div class="d-flex justify-content-center">
            <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-facebook me-1_5">
              <i class="icon-base ti tabler-brand-facebook-filled icon-20px"></i>
            </a>

            <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-twitter me-1_5">
              <i class="icon-base ti tabler-brand-twitter-filled icon-20px"></i>
            </a>

            <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-github me-1_5">
              <i class="icon-base ti tabler-brand-github-filled icon-20px"></i>
            </a>

            <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-google-plus">
              <i class="icon-base ti tabler-brand-google-filled icon-20px"></i>
            </a>
          </div>
        </div>
      </div>
      <!-- Register Card -->
    </div>
  </div>
</div>
<!-- ================================
     Terms & Conditions Modal (Premium)
================================ -->
<div class="modal fade fixed-modal" id="termsModal" tabindex="-1" aria-labelledby="termsLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content shadow-lg border-0" style="border-radius:18px;">
      
      <!-- Header -->
      <div class="modal-header" style="background:#f7f8fa; border-bottom: none;">
        <h5 class="modal-title fw-bold" id="termsLabel">
          Terms & Conditions
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Body -->
      <div class="modal-body" style="padding: 25px; font-size: 15px; line-height: 1.7;">
        <h6 class="fw-bold">1. Introduction</h6>
        <p>
          By creating an account, you agree to our Terms & Conditions and Privacy Policy.
          Please read everything carefully before continuing.
        </p>

        <h6 class="fw-bold mt-3">2. User Responsibilities</h6>
        <p>
          You agree to provide accurate information and keep your account secure. You are responsible 
          for all activities that occur under your login credentials.
        </p>

        <h6 class="fw-bold mt-3">3. Privacy Policy</h6>
        <p>
          We take your privacy seriously. We only collect data needed to provide services and improve 
          your user experience. We do not sell your data to third parties.
        </p>

        <h6 class="fw-bold mt-3">4. Payments & Refunds</h6>
        <p>
          All purchases follow our official refund and cancellation process. Refund approval depends
          on the administrator’s final review.
        </p>

        <h6 class="fw-bold mt-3">5. Account Termination</h6>
        <p>
          We may suspend or terminate accounts violating policies, fraudulent activities, or misuse
          of the platform.
        </p>

        <h6 class="fw-bold mt-3">6. Acceptance</h6>
        <p>
          By creating an account, you confirm that you have read and agree to all Terms and Conditions.
        </p>
      </div>

      <!-- Footer -->
      <div class="modal-footer" style="border-top: none;">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" data-bs-dismiss="modal">I Agree</button>
      </div>

    </div>
  </div>
</div>
<style>
/* ==========================================
   MOBILE PREMIUM OPTIMIZATION (≤ 576px)
========================================== */
@media (max-width: 576px) {

  /* Make modal appear like a modern bottom-sheet */
  #termsModal .modal-dialog {
      margin: 0;
      width: 100%;
      max-width: 100%;
      height: 100%;
      display: flex;
      align-items: flex-end; /* bottom sheet style */
  }

  #termsModal .modal-content {
      border-radius: 22px 22px 0 0 !important;
      padding-bottom: 25px;
      animation: fadeUp .35s ease-out;
  }

  /* Mobile animation */
  @keyframes fadeUp {
      from { opacity: 0; transform: translateY(40px); }
      to   { opacity: 1; transform: translateY(0); }
  }

  /* Modal header adjustments */
  #termsModal .modal-header {
      padding: 18px 20px !important;
      text-align: center;
      border-bottom: none;
  }

  #termsModal .modal-title {
      font-size: 18px;
      width: 100%;
      text-align: center;
  }

  /* Body text optimized for reading */
  #termsModal .modal-body {
      padding: 20px !important;
      font-size: 14px;
      line-height: 1.65;
      max-height: 55vh;
      overflow-y: auto;
  }

  /* Footer buttons become full-width */
  #termsModal .modal-footer {
      flex-direction: column;
      gap: 10px;
      padding: 16px 20px !important;
      
  }

  #termsModal .btn {
      width: 100%;
      padding: 10px 18px;
      font-size: 15px;
      border-radius: 12px;
  }

  /* Increase tap area for close button */
  #termsModal .btn-close {
      transform: scale(1.25);
  }
}
/* Make modal behave like an absolute top modal */
.fixed-modal .modal-dialog {
    position: absolute;
    top: 15vh !important;
    left: 50%;
    transform: translateX(-50%) !important; /* center horizontally */
    margin: 0 !important;
    padding-top: 0 !important;
}

/* Remove Bootstrap’s vertical centering on default modals */
.fixed-modal .modal-dialog-centered {
    display: block !important;
}

/* Optional: remove overflow “jumping” */
.fixed-modal .modal-content {
    border-radius: 16px !important;
    margin-top: 0 !important;
    animation: slideDown .25s ease-out;
}
.terms-checked-animate {
    transition: background 0.4s ease;
    background: #e8f7ff;
    padding: 4px 6px;
    border-radius: 6px;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

</style>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const agreeBtn = document.querySelector("#termsModal .btn-primary");
    const termsCheckbox = document.getElementById("terms-conditions");

    if (agreeBtn && termsCheckbox) {
        agreeBtn.addEventListener("click", function () {
            termsCheckbox.checked = true;

            // Optional: Add a small highlight flash
            termsCheckbox.closest("label")?.classList.add("terms-checked-animate");

            setTimeout(() => {
                termsCheckbox.closest("label")?.classList.remove("terms-checked-animate");
            }, 600);
        });
    }
});
</script>


@endsection
